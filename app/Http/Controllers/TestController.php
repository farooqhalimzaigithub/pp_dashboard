<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class TestController extends Controller
{
    public function sendEmail(Request $request)
    {
        // Validate input
        $request->validate([
            'subject' => 'required|string|max:255',
            'emailBody' => 'required|string',
            'attachment' => 'nullable|file',
        ]);

        // Email details
        $recipients = [
            'user1@example.com', 'user2@example.com', 'user3@example.com',
            // Add more recipients here
        ];
        $subject = $request->subject;
        $body = $request->emailBody;  // HTML from TinyMCE
        $attachment = $request->file('attachment');  // Optional attachment

        // Loop through each recipient and send email
        foreach ($recipients as $recipient) {
            $this->sendEmailToUser($recipient, $subject, $body, $attachment);
        }

        return response()->json(['message' => 'Emails sent successfully']);
    }

    private function sendEmailToUser($recipient, $subject, $body, $attachment = null)
    {
        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);

        try {
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host       = 'sandbox.smtp.mailtrap.io';  // Set your SMTP host
            $mail->SMTPAuth   = true;
            $mail->Username   = 'f6a78577fa5917';            // SMTP username
            $mail->Password   = 'b5d5ecaf2e2be0';            // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 2525;

            // Email sender
            $mail->setFrom('your-email@example.com', 'Your Name');

            // Add recipient individually
            $mail->addAddress($recipient);

            // Email subject and body (HTML enabled from TinyMCE)
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;  // Rich text from TinyMCE
            $mail->AltBody = strip_tags($body);  // Fallback for plain text

            // Attach file if uploaded
            if ($attachment) {
                $mail->addAttachment($attachment->getPathname(), $attachment->getClientOriginalName());
            }

            // Send the email
            $mail->send();
        } catch (Exception $e) {
            // Handle error
            return response()->json(['error' => $mail->ErrorInfo], 500);
        }
    }
}
