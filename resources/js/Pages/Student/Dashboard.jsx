import React, { useState, useEffect } from 'react';
import { Link } from '@inertiajs/react';
import StudentLayout from '@/Layouts/StudentLayout';

export default function Dashboard({ auth, enrollments, totalLearningTime, certificatesCount, liveClass }) {
    // Countdown state
    const [countdown, setCountdown] = useState({ days: 0, hours: 0, minutes: 0, seconds: 0 });

    // Update countdown every second
    useEffect(() => {
        if (!liveClass || liveClass.status === 'live') {
            return;
        }

        const calculateCountdown = () => {
            const [day, month, year] = liveClass.start_date.split('-');
            const [startHours, startMinutes] = liveClass.start_time.split(':');

            const classDate = new Date(year, month - 1, day, startHours, startMinutes);
            const now = new Date();
            const diff = classDate - now;

            if (diff <= 0) {
                setCountdown({ days: 0, hours: 0, minutes: 0, seconds: 0 });
                return;
            }

            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

            setCountdown({ days, hours, minutes, seconds });
        };

        calculateCountdown();
        const interval = setInterval(calculateCountdown, 1000);

        return () => clearInterval(interval);
    }, [liveClass]);
    // Convert minutes to hours and minutes
    const formatLearningTime = (minutes) => {
        if (!minutes || minutes === 0) return '0h 0m';
        const hours = Math.floor(minutes / 60);
        const mins = minutes % 60;
        return `${hours}h ${mins}m`;
    };

    // Format date time
    const formatDateTime = (date, time) => {
        if (!date || !time) return '';
        // date is in 'd-m-y' format, time is in 'H:i' format
        const [day, month, year] = date.split('-');
        const [hours, minutes] = time.split(':');

        const dateObj = new Date(year, month - 1, day, hours, minutes);

        return dateObj.toLocaleString('en-US', {
            weekday: 'short',
            month: 'short',
            day: 'numeric',
            hour: 'numeric',
            minute: '2-digit',
            hour12: true
        });
    };

    // Add wave animation styles
    const waveAnimation = `
        @keyframes wave {
            0%, 100% { height: 8px; }
            50% { height: 32px; }
        }
        .animate-wave {
            animation: wave 0.8s ease-in-out infinite;
        }
    `;

    // Inject styles
    if (typeof document !== 'undefined' && !document.getElementById('wave-animation')) {
        const style = document.createElement('style');
        style.id = 'wave-animation';
        style.textContent = waveAnimation;
        document.head.appendChild(style);
    }

    return (
        <StudentLayout auth={auth}>
            <div className="space-y-6">
                {/* Welcome Section */}
                <div className="bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl p-8 text-white shadow-xl">
                    <h1 className="text-3xl font-bold mb-2">
                        Welcome back, {auth.user.name}!
                    </h1>
                    <p className="text-purple-100">
                        Continue learning and achieve your goals
                    </p>
                </div>

                {/* Live Class Banner */}
                {liveClass && liveClass.status !== 'canceled' && (
                    <div className={`rounded-2xl shadow-xl border-2 overflow-hidden ${
                        liveClass.status === 'live'
                            ? 'bg-gradient-to-r from-red-500 to-pink-500 border-red-300'
                            : 'bg-gradient-to-r from-blue-500 to-purple-500 border-blue-300'
                    }`}>
                        {liveClass.status === 'live' ? (
                            // LIVE CLASS - Video Player Style Box
                            <div className="w-full max-w-2xl mx-auto">
                                <div className="relative bg-black aspect-video flex items-center justify-center">
                                    {liveClass.thumbnail_url ? (
                                        <img
                                            src={liveClass.thumbnail_url}
                                            alt="Live class"
                                            className="w-full h-full object-cover opacity-60"
                                        />
                                    ) : null}

                                    {/* Live indicator overlay */}
                                    <div className="absolute top-4 left-4 flex items-center space-x-2">
                                        <span className="px-3 py-1 bg-red-600 text-white text-sm font-bold rounded-full animate-pulse">
                                            ● LIVE
                                        </span>
                                    </div>

                                    {/* Center content */}
                                    <div className="absolute inset-0 flex flex-col items-center justify-center text-white px-4">
                                        {/* Wave animation */}
                                        <div className="flex items-end space-x-2 mb-4">
                                            {[...Array(7)].map((_, i) => (
                                                <div
                                                    key={i}
                                                    className="w-2 bg-white/80 rounded-full animate-wave"
                                                    style={{
                                                        height: `${20 + Math.random() * 30}px`,
                                                        animationDelay: `${i * 0.1}s`,
                                                    }}
                                                />
                                            ))}
                                        </div>

                                        <h3 className="text-2xl font-bold mb-2 text-center px-4">
                                            {liveClass.topic}
                                        </h3>
                                        <p className="text-white/80 text-base mb-4">
                                            by {liveClass.instructor.name}
                                        </p>

                                        <a
                                            href={liveClass.meeting_link}
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            className="px-6 py-2 bg-white text-red-600 rounded-lg font-bold text-base hover:bg-gray-100 transition-all duration-300 hover:scale-105 flex items-center space-x-2"
                                        >
                                            <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                                            </svg>
                                            <span>Join Class</span>
                                        </a>
                                    </div>

                                    {/* Bottom info bar */}
                                    <div className="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-3">
                                        <div className="flex items-center justify-between text-white">
                                            <div className="flex items-center space-x-2">
                                                <div className="w-2 h-2 bg-red-500 rounded-full animate-pulse"></div>
                                                <span className="text-xs">Ongoing Session</span>
                                            </div>
                                            <span className="text-xs text-white/70">
                                                Duration: {liveClass.duration_minutes} minutes
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ) : (
                            // UPCOMING CLASS
                            <div className="p-6">
                                <div className="flex items-center justify-between">
                                    <div className="flex items-center space-x-4 flex-1">
                                        <div className="w-20 h-20 rounded-xl bg-white/20 flex items-center justify-center flex-shrink-0">
                                            <svg className="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                                            </svg>
                                        </div>
                                        <div className="text-white flex-1">
                                            <h3 className="text-xl font-bold mb-1">Upcoming Live Class</h3>
                                            <p className="text-white/90 font-semibold">{liveClass.topic}</p>
                                            <p className="text-white/80 text-sm">
                                                <svg className="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 8zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clipRule="evenodd" />
                                                </svg>
                                                {formatDateTime(liveClass.start_date, liveClass.start_time)}
                                            </p>
                                            <p className="text-white/70 text-xs mt-1">Duration: {liveClass.duration_minutes} minutes</p>
                                        </div>
                                    </div>
                                    <div className="flex-shrink-0 text-right">
                                        <div className="text-white/70 text-xs mb-1">Starting in:</div>
                                        <div className="flex items-center space-x-1 text-white font-mono font-bold">
                                            {countdown.days > 0 && (
                                                <>
                                                    <span className="bg-white/20 px-2 py-1 rounded">{countdown.days}d</span>
                                                    <span>:</span>
                                                </>
                                            )}
                                            <span className="bg-white/20 px-2 py-1 rounded">{String(countdown.hours).padStart(2, '0')}h</span>
                                            <span>:</span>
                                            <span className="bg-white/20 px-2 py-1 rounded">{String(countdown.minutes).padStart(2, '0')}m</span>
                                            <span>:</span>
                                            <span className="bg-white/20 px-2 py-1 rounded">{String(countdown.seconds).padStart(2, '0')}s</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        )}
                    </div>
                )}

                {/* Stats Overview */}
                <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div className="bg-white rounded-xl p-6 shadow-lg border border-purple-100">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-gray-600 text-sm font-medium">Enrolled Courses</p>
                                <p className="text-3xl font-bold text-gray-900 mt-2">
                                    {enrollments.length}
                                </p>
                            </div>
                            <div className="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center">
                                <svg className="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div className="bg-white rounded-xl p-6 shadow-lg border border-purple-100">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-gray-600 text-sm font-medium">Total Learning Time</p>
                                <p className="text-3xl font-bold text-gray-900 mt-2">
                                    {formatLearningTime(totalLearningTime)}
                                </p>
                            </div>
                            <div className="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-500 rounded-lg flex items-center justify-center">
                                <svg className="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div className="bg-white rounded-xl p-6 shadow-lg border border-purple-100">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-gray-600 text-sm font-medium">Certificates Earned</p>
                                <p className="text-3xl font-bold text-gray-900 mt-2">
                                    {certificatesCount || 0}
                                </p>
                            </div>
                            <div className="w-12 h-12 bg-gradient-to-br from-green-500 to-teal-500 rounded-lg flex items-center justify-center">
                                <svg className="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                {/* My Courses Section */}
                <div>
                    <h2 className="text-2xl font-bold text-gray-900 mb-6">My Enrolled Courses</h2>

                    {enrollments.length === 0 ? (
                        <div className="bg-white rounded-xl p-12 text-center shadow-lg border border-purple-100">
                            <svg className="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <h3 className="text-xl font-semibold text-gray-900 mb-2">No courses yet</h3>
                            <p className="text-gray-600">You haven't enrolled in any courses yet.</p>
                        </div>
                    ) : (
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            {enrollments.map((enrollment) => (
                                <Link
                                    key={enrollment.id}
                                    href={`/student/courses/${enrollment.course.id}`}
                                    className="group"
                                >
                                    <div className="bg-white rounded-xl overflow-hidden shadow-lg border border-purple-100 transition-all duration-300 hover:shadow-2xl hover:scale-105">
                                        {/* Course Thumbnail */}
                                        <div className="relative h-48 bg-gradient-to-br from-purple-400 to-pink-400">
                                            {enrollment.course.thumbnail_path ? (
                                                <img
                                                    src={`/storage/${enrollment.course.thumbnail_path}`}
                                                    alt={enrollment.course.title}
                                                    className="w-full h-full object-cover"
                                                />
                                            ) : enrollment.course.thumbnail_url ? (
                                                <img
                                                    src={enrollment.course.thumbnail_url}
                                                    alt={enrollment.course.title}
                                                    className="w-full h-full object-cover"
                                                />
                                            ) : (
                                                <div className="w-full h-full flex items-center justify-center text-white">
                                                    <svg className="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            )}
                                            <div className="absolute top-3 right-3 flex flex-col items-end space-y-2">
                                                {enrollment.course.is_completed && (
                                                    <span className="px-3 py-1 bg-green-500 text-white rounded-full text-xs font-semibold flex items-center space-x-1">
                                                        <svg className="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clipRule="evenodd" />
                                                        </svg>
                                                        <span>Completed</span>
                                                    </span>
                                                )}
                                                <span className={`px-3 py-1 rounded-full text-xs font-semibold ${
                                                    enrollment.course.type === 'FREE'
                                                        ? 'bg-green-500 text-white'
                                                        : 'bg-purple-600 text-white'
                                                }`}>
                                                    {enrollment.course.type === 'FREE' ? 'Free' : `৳${enrollment.course.price}`}
                                                </span>
                                            </div>
                                        </div>

                                        {/* Course Info */}
                                        <div className="p-5">
                                            <div className="flex items-center justify-between mb-2">
                                                <span className="px-2 py-1 bg-purple-100 text-purple-600 text-xs font-semibold rounded">
                                                    {enrollment.course.category?.name || 'General'}
                                                </span>
                                                <span className="text-xs text-gray-500 font-semibold">
                                                    {enrollment.course.progress}% Complete
                                                </span>
                                            </div>

                                            {/* Progress Bar */}
                                            <div className="w-full bg-gray-200 rounded-full h-2 mb-3">
                                                <div
                                                    className="bg-gradient-to-r from-purple-500 to-pink-500 h-2 rounded-full transition-all duration-300"
                                                    style={{ width: `${enrollment.course.progress}%` }}
                                                ></div>
                                            </div>

                                            <h3 className="text-lg font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-purple-600 transition-colors">
                                                {enrollment.course.title}
                                            </h3>

                                            <p className="text-sm text-gray-600 mb-4 line-clamp-2">
                                                {enrollment.course.short_description || enrollment.course.description}
                                            </p>

                                            <div className="flex items-center justify-between pt-3 border-t border-gray-200">
                                                <div className="flex items-center space-x-2">
                                                    <div className="w-6 h-6 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white text-xs font-semibold">
                                                        {enrollment.course.instructor?.name?.charAt(0) || 'I'}
                                                    </div>
                                                    <span className="text-xs text-gray-600">
                                                        {enrollment.course.instructor?.name || 'Instructor'}
                                                    </span>
                                                </div>
                                                <span className="text-xs text-gray-500">
                                                    Enrolled {new Date(enrollment.enrolled_at).toLocaleDateString()}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </Link>
                            ))}
                        </div>
                    )}
                </div>
            </div>
        </StudentLayout>
    );
}
