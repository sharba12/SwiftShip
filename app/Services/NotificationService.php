<?php

namespace App\Services;

use App\Models\Parcel;
use App\Models\ParcelNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Send notification when parcel status changes
     */
    public function notifyStatusChange(Parcel $parcel, string $oldStatus, string $newStatus)
    {
        $customer = $parcel->customer;
        
        if (!$customer) {
            return;
        }

        // Send Email Notification
        if ($customer->email && $customer->email_notifications) {
            $this->sendEmailNotification($parcel, $newStatus);
        }

        // Send SMS Notification (if enabled)
        if ($customer->phone && $customer->sms_notifications) {
            $this->sendSMSNotification($parcel, $newStatus);
        }
    }

    /**
     * Send email notification
     */
    protected function sendEmailNotification(Parcel $parcel, string $status)
    {
        try {
            $customer = $parcel->customer;
            
            Mail::send('emails.parcel-status-update', [
                'parcel' => $parcel,
                'status' => $status,
                'customer' => $customer
            ], function ($message) use ($customer, $parcel, $status) {
                $message->to($customer->email, $customer->name)
                    ->subject('Parcel Update: ' . ucfirst(str_replace('_', ' ', $status)));
            });

            // Log notification
            ParcelNotification::create([
                'parcel_id' => $parcel->id,
                'type' => 'email',
                'status' => 'sent',
                'recipient' => $customer->email,
                'message' => "Status updated to: " . $status,
            ]);

            Log::info("Email sent to {$customer->email} for parcel {$parcel->tracking_id}");
            
        } catch (\Exception $e) {
            ParcelNotification::create([
                'parcel_id' => $parcel->id,
                'type' => 'email',
                'status' => 'failed',
                'recipient' => $customer->email,
                'message' => "Status updated to: " . $status,
                'error_message' => $e->getMessage(),
            ]);

            Log::error("Email failed for parcel {$parcel->tracking_id}: " . $e->getMessage());
        }
    }

    /**
     * Send SMS notification
     * Note: You'll need to configure an SMS provider like Twilio
     */
    protected function sendSMSNotification(Parcel $parcel, string $status)
    {
        try {
            $customer = $parcel->customer;
            $message = $this->getSMSMessage($parcel, $status);

            // TODO: Integrate with SMS provider (Twilio, Nexmo, etc.)
            // Example with Twilio:
            // $twilio = new Client(config('services.twilio.sid'), config('services.twilio.token'));
            // $twilio->messages->create($customer->phone, [
            //     'from' => config('services.twilio.from'),
            //     'body' => $message
            // ]);

            // For now, just log it
            Log::info("SMS would be sent to {$customer->phone}: {$message}");

            ParcelNotification::create([
                'parcel_id' => $parcel->id,
                'type' => 'sms',
                'status' => 'sent',
                'recipient' => $customer->phone,
                'message' => $message,
            ]);

        } catch (\Exception $e) {
            ParcelNotification::create([
                'parcel_id' => $parcel->id,
                'type' => 'sms',
                'status' => 'failed',
                'recipient' => $customer->phone,
                'message' => $message ?? '',
                'error_message' => $e->getMessage(),
            ]);

            Log::error("SMS failed for parcel {$parcel->tracking_id}: " . $e->getMessage());
        }
    }

    /**
     * Generate SMS message based on status
     */
    protected function getSMSMessage(Parcel $parcel, string $status): string
    {
        $messages = [
            'pending' => "Your parcel {$parcel->tracking_id} is pending pickup.",
            'in_transit' => "Your parcel {$parcel->tracking_id} is now in transit. Track: " . route('track.page'),
            'out_for_delivery' => "Your parcel {$parcel->tracking_id} is out for delivery today!",
            'delivered' => "Your parcel {$parcel->tracking_id} has been delivered. Thank you!",
            'failed' => "Delivery attempt failed for {$parcel->tracking_id}. We'll try again.",
        ];

        return $messages[$status] ?? "Parcel {$parcel->tracking_id} status: {$status}";
    }

    /**
     * Send delivery confirmation with rating link
     */
    public function sendDeliveryConfirmation(Parcel $parcel)
    {
        $customer = $parcel->customer;
        
        if (!$customer || !$customer->email) {
            return;
        }

        try {
            Mail::send('emails.delivery-confirmation', [
                'parcel' => $parcel,
                'customer' => $customer,
                'ratingUrl' => route('rating.create', $parcel->tracking_id),
            ], function ($message) use ($customer, $parcel) {
                $message->to($customer->email, $customer->name)
                    ->subject('Delivered: ' . $parcel->tracking_id . ' - Rate Your Experience');
            });

            Log::info("Delivery confirmation sent to {$customer->email}");
            
        } catch (\Exception $e) {
            Log::error("Delivery confirmation failed: " . $e->getMessage());
        }
    }
}