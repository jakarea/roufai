<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment Successful</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 20px;">
        <!-- Header -->
        <div style="text-align: center; padding: 20px 0; border-bottom: 2px solid #E850FF;">
            <h1 style="color: #E850FF; margin: 0;">Rouf AI Academy</h1>
            <p style="color: #666; margin: 5px 0 0 0;">AI কোর্স প্ল্যাটফর্ম</p>
        </div>

        <!-- Content -->
        <div style="padding: 30px 0;">
            <h2 style="color: #333; font-size: 24px;">অভিনন্দন! আপনি সফলভাবে এনরোল হয়েছেন 🎉</h2>

            <p style="color: #666; font-size: 16px; line-height: 1.6;">প্রিয় <strong>{{ $userName }}</strong>,</p>

            <p style="color: #666; font-size: 16px; line-height: 1.6;">
                আপনি সফলভাবে <strong>{{ $courseTitle }}</strong> কোর্সে এনরোল হয়েছেন। এখন আপনি কোর্সের সমস্ত কন্টেন্ট এবং লাইভ ক্লাসগুলোতে অ্যাক্সেস করতে পারবেন।
            </p>

            <div style="background-color: #f9f9f9; padding: 20px; border-left: 4px solid #E850FF; margin: 20px 0;">
                <h3 style="color: #333; margin: 0 0 10px 0;">কোর্সের বিবরণ:</h3>
                <p style="color: #666; margin: 5px 0;"><strong>কোর্স:</strong> {{ $courseTitle }}</p>
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('courses.overview', $courseSlug) }}"
                   style="background-color: #E850FF; color: #ffffff; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block;">
                    কোর্সে যান →
                </a>
            </div>

            <p style="color: #666; font-size: 16px; line-height: 1.6;">
                যদি কোনো প্রশ্ন থাকে, আমাদের সাথে যোগাযোগ করতে দ্বিধা করবেন না।
            </p>

            <p style="color: #666; font-size: 16px; line-height: 1.6;">
                শুভকামনা,<br>
                <strong>Rouf AI Academy টিম</strong>
            </p>
        </div>

        <!-- Footer -->
        <div style="border-top: 1px solid #ddd; padding-top: 20px; text-align: center; color: #999; font-size: 12px;">
            <p style="margin: 0;">&copy; {{ date('Y') }} Rouf AI Academy. All rights reserved.</p>
            <p style="margin: 5px 0 0 0;">এই ইমেইলটি স্বয়ংক্রিয়ভাবে পাঠানো হয়েছে। দয়া করে এতে উত্তর করবেন না।</p>
        </div>
    </div>
</body>
</html>
