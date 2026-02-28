<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Enrollment Request</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 20px;">
        <!-- Header -->
        <div style="text-align: center; padding: 20px 0; border-bottom: 2px solid #E850FF;">
            <h1 style="color: #E850FF; margin: 0;">Rouf AI Academy</h1>
            <p style="color: #666; margin: 5px 0 0 0;">Admin Notification</p>
        </div>

        <!-- Content -->
        <div style="padding: 30px 0;">
            <h2 style="color: #333; font-size: 24px;">🔔 New Enrollment Request</h2>

            <p style="color: #666; font-size: 16px; line-height: 1.6;">
                একজন শিক্ষার্থী কোর্সে এনরোলমেন্ট রিকোয়েস্ট জমা দিয়েছেন। নিচে বিস্তারিত তথ্য দেওয়া হলো:
            </p>

            <div style="background-color: #f9f9f9; padding: 20px; border-left: 4px solid #E850FF; margin: 20px 0;">
                <h3 style="color: #333; margin: 0 0 15px 0;">শিক্ষার্থীর তথ্য:</h3>
                <p style="color: #666; margin: 5px 0;"><strong>নাম:</strong> {{ $studentName }}</p>
                <p style="color: #666; margin: 5px 0;"><strong>ইমেইল:</strong> {{ $studentEmail }}</p>
                <p style="color: #666; margin: 5pxpx 0;"><strong>ফোন:</strong> {{ $studentPhone }}</p>

                <h3 style="color: #333; margin: 20px 0 15px 0;">কোর্সের তথ্য:</h3>
                <p style="color: #666; margin: 5px 0;"><strong>কোর্স:</strong> {{ $courseTitle }}</p>
                <p style="color: #666; margin: 5px 0;"><strong>মূল্য:</strong> ৳{{ number_format($coursePrice) }}</p>

                <h3 style="color: #333; margin: 20px 0 15px 0;">পেমেন্টের তথ্য:</h3>
                <p style="color: #666; margin: 5px 0;"><strong>পেমেন্ট পদ্ধতি:</strong> {{ strtoupper($paymentMethod) }}</p>
                <p style="color: #666; margin: 5px 0;"><strong>ট্রানজ্যাকশন ID:</strong> {{ $transactionId }}</p>
                <p style="color: #666; margin: 5px 0;"><strong>পরিশোধিত পরিমাণ:</strong> ৳{{ number_format($paidAmount) }}</p>
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <p style="color: #666; font-size: 14px;">
                    অ্যাডমিন প্যানেলে রিকোয়েস্টটি পর্যালোচনা করতে নিচের বাটনে ক্লিক করুন।
                </p>
                <a href="{{ url('/admin/enrollment-requests') }}"
                   style="background-color: #E850FF; color: #ffffff; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block; margin-top: 10px;">
                    অ্যাডমিন প্যানেলে যান →
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div style="border-top: 1px solid #ddd; padding-top: 20px; text-align: center; color: #999; font-size: 12px;">
            <p style="margin: 0;">&copy; {{ date('Y') }} Rouf AI Academy. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
