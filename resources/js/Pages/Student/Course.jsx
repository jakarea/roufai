import React, { useState, useEffect } from 'react';
import { Link, useForm, usePage, router } from '@inertiajs/react';
import StudentLayout from '@/Layouts/StudentLayout';

export default function Course({ auth, course, completedLessons, userReview }) {
    const { flash } = usePage().props;
    const [selectedLesson, setSelectedLesson] = useState(() => {
        // Select first lesson of first module by default
        if (course.modules && course.modules.length > 0 && course.modules[0].lessons.length > 0) {
            return course.modules[0].lessons[0];
        }
        return null;
    });
    const [showReviewModal, setShowReviewModal] = useState(false);
    const [isMarking, setIsMarking] = useState(false);

    // Check for next lesson to auto-select after reload
    useEffect(() => {
        const nextLessonId = sessionStorage.getItem('nextLessonId');
        if (nextLessonId) {
            sessionStorage.removeItem('nextLessonId');

            // Find and select the next lesson
            for (const module of course.modules) {
                for (const lesson of module.lessons) {
                    if (lesson.id === parseInt(nextLessonId)) {
                        setSelectedLesson(lesson);
                        return;
                    }
                }
            }
        }
    }, []);

    // Review form
    const reviewForm = useForm({
        rating: 5,
        comment: '',
    });

    const handleMarkComplete = (lessonId) => {
        setIsMarking(true);

        // Find next lesson before submitting
        let foundCurrent = false;
        let nextLesson = null;

        for (const module of course.modules) {
            for (const lesson of module.lessons) {
                if (foundCurrent) {
                    nextLesson = lesson;
                    break;
                }
                if (lesson.id === lessonId) {
                    foundCurrent = true;
                }
            }
            if (nextLesson) break;
        }

        // Store next lesson in sessionStorage to restore after reload
        if (nextLesson) {
            sessionStorage.setItem('nextLessonId', nextLesson.id.toString());
        }

        router.post(`/student/lessons/complete`, {
            lesson_id: lessonId,
            course_id: course.id,
        }, {
            onError: (errors) => {
                setIsMarking(false);
                console.error('Errors:', errors);
            },
            preserveState: false,
        });
    };

    const handleReviewSubmit = (e) => {
        e.preventDefault();
        reviewForm.post(`/student/courses/${course.id}/review`, {
            onSuccess: () => {
                setShowReviewModal(false);
                reviewForm.reset();
            },
        });
    };

    const getVideoEmbedUrl = (url) => {
        if (!url) return null;

        // YouTube
        const youtubeMatch = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\s]+)/);
        if (youtubeMatch) {
            return `https://www.youtube.com/embed/${youtubeMatch[1]}`;
        }

        // Vimeo
        const vimeoMatch = url.match(/vimeo\.com\/(\d+)/);
        if (vimeoMatch) {
            return `https://player.vimeo.com/video/${vimeoMatch[1]}`;
        }

        return url;
    };

    const renderStars = (rating) => {
        return [...Array(5)].map((_, i) => (
            <svg
                key={i}
                className={`w-5 h-5 ${
                    i < rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600'
                }`}
                fill="currentColor"
                viewBox="0 0 20 20"
            >
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
        ));
    };

    return (
        <StudentLayout auth={auth}>
            <div className="space-y-6">
                {/* Flash Messages */}
                {flash?.success && (
                    <div className="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-200 px-4 py-3 rounded-lg">
                        {flash.success}
                    </div>
                )}
                {flash?.error && (
                    <div className="bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-200 px-4 py-3 rounded-lg">
                        {flash.error}
                    </div>
                )}

                {/* Course Header */}
                <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-purple-100 dark:border-purple-800">
                    <div className="flex items-start justify-between">
                        <div className="flex-1">
                            <div className="flex items-center space-x-3 mb-4">
                                <span className="px-3 py-1 bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-400 text-sm font-semibold rounded">
                                    {course.category?.name || 'General'}
                                </span>
                                <span className={`px-3 py-1 text-sm font-semibold rounded ${
                                    course.type === 'FREE'
                                        ? 'bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400'
                                        : 'bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-400'
                                }`}>
                                    {course.type === 'FREE' ? 'Free Course' : `৳${course.price}`}
                                </span>
                            </div>

                            <h1 className="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                                {course.title}
                            </h1>

                            <p className="text-gray-600 dark:text-gray-400 mb-4">
                                {course.description}
                            </p>

                            <div className="flex items-center space-x-6 text-sm text-gray-600 dark:text-gray-400">
                                <div className="flex items-center space-x-2">
                                    <div className="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-semibold">
                                        {course.instructor?.name?.charAt(0) || 'I'}
                                    </div>
                                    <div>
                                        <p className="font-medium text-gray-900 dark:text-white">{course.instructor?.name || 'Instructor'}</p>
                                        <p className="text-xs">{course.instructor?.bio || ''}</p>
                                    </div>
                                </div>

                                <div className="flex items-center space-x-1">
                                    {renderStars(Math.round(Number(course.reviews_avg_rating) || 0))}
                                    <span className="ml-2 text-gray-900 dark:text-white font-semibold">
                                        {course.reviews_avg_rating ? Number(course.reviews_avg_rating).toFixed(1) : 'N/A'}
                                    </span>
                                    <span className="text-gray-500">
                                        ({course.enrollments_count || 0} students)
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Main Content */}
                <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {/* Video Player & Content */}
                    <div className="lg:col-span-2 space-y-6">
                        {/* Video Player */}
                        {selectedLesson ? (
                            <div className="bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-lg border border-purple-100 dark:border-purple-800">
                                <div className="aspect-video bg-black">
                                    {getVideoEmbedUrl(selectedLesson.video_url) ? (
                                        <iframe
                                            src={getVideoEmbedUrl(selectedLesson.video_url)}
                                            className="w-full h-full"
                                            allowFullScreen
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        />
                                    ) : (
                                        <div className="w-full h-full flex items-center justify-center text-white">
                                            <div className="text-center">
                                                <svg className="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                </svg>
                                                <p className="text-lg">No video available</p>
                                            </div>
                                        </div>
                                    )}
                                </div>

                                <div className="p-6">
                                    <h2 className="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                                        {selectedLesson.title}
                                    </h2>
                                    <p className="text-gray-600 dark:text-gray-400 mb-4">
                                        {selectedLesson.description}
                                    </p>

                                    {selectedLesson.duration && (
                                        <div className="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                                            <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>Duration: {selectedLesson.duration}</span>
                                        </div>
                                    )}

                                    <div className="mt-6 flex items-center justify-between">
                                        <button
                                            onClick={() => handleMarkComplete(selectedLesson.id)}
                                            disabled={isMarking || completedLessons.includes(selectedLesson.id)}
                                            className={`px-6 py-3 rounded-lg font-semibold transition-all duration-200 ${
                                                completedLessons.includes(selectedLesson.id)
                                                    ? 'bg-green-500 text-white cursor-default'
                                                    : 'bg-gradient-to-r from-purple-600 to-pink-600 text-white hover:from-purple-700 hover:to-pink-700'
                                            }`}
                                        >
                                            {completedLessons.includes(selectedLesson.id) ? (
                                                <span className="flex items-center space-x-2">
                                                    <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clipRule="evenodd" />
                                                    </svg>
                                                    <span>Completed</span>
                                                </span>
                                            ) : isMarking ? (
                                                'Marking...'
                                            ) : (
                                                'Mark as Complete'
                                            )}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        ) : (
                            <div className="bg-white dark:bg-gray-800 rounded-xl p-12 text-center shadow-lg border border-purple-100 dark:border-purple-800">
                                <svg className="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-2">Select a Lesson</h3>
                                <p className="text-gray-600 dark:text-gray-400">Choose a lesson from the course content to start learning.</p>
                            </div>
                        )}

                        {/* Reviews Section */}
                        <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-purple-100 dark:border-purple-800">
                            <div className="flex items-center justify-between mb-6">
                                <h2 className="text-2xl font-bold text-gray-900 dark:text-white">Reviews</h2>
                                {!userReview && (
                                    <button
                                        onClick={() => setShowReviewModal(true)}
                                        className="px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg font-semibold hover:from-purple-700 hover:to-pink-700 transition-all"
                                    >
                                        Write a Review
                                    </button>
                                )}
                            </div>

                            {course.reviews.length === 0 ? (
                                <div className="text-center py-8">
                                    <p className="text-gray-600 dark:text-gray-400">No reviews yet. Be the first to review this course!</p>
                                </div>
                            ) : (
                                <div className="space-y-4">
                                    {course.reviews.map((review) => (
                                        <div key={review.id} className="border-b border-gray-200 dark:border-gray-700 pb-4 last:border-b-0">
                                            <div className="flex items-center justify-between mb-2">
                                                <div className="flex items-center space-x-3">
                                                    <div className="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-semibold">
                                                        {review.user.name.charAt(0)}
                                                    </div>
                                                    <div>
                                                        <p className="font-semibold text-gray-900 dark:text-white">{review.user.name}</p>
                                                        <div className="flex items-center space-x-1">
                                                            {renderStars(review.rating)}
                                                        </div>
                                                    </div>
                                                </div>
                                                <span className="text-sm text-gray-500 dark:text-gray-400">
                                                    {new Date(review.created_at).toLocaleDateString()}
                                                </span>
                                            </div>
                                            <p className="text-gray-600 dark:text-gray-400">{review.comment}</p>
                                        </div>
                                    ))}
                                </div>
                            )}
                        </div>
                    </div>

                    {/* Course Content Sidebar */}
                    <div className="lg:col-span-1">
                        <div className="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-purple-100 dark:border-purple-800 sticky top-20">
                            <div className="p-4 border-b border-gray-200 dark:border-gray-700">
                                <h2 className="text-xl font-bold text-gray-900 dark:text-white">Course Content</h2>
                                <p className="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    {course.modules.length} modules • {course.modules.reduce((acc, module) => acc + module.lessons.length, 0)} lessons
                                </p>
                            </div>

                            <div className="max-h-[600px] overflow-y-auto">
                                {course.modules.map((module) => (
                                    <div key={module.id} className="border-b border-gray-200 dark:border-gray-700 last:border-b-0">
                                        <div className="p-4 bg-gray-50 dark:bg-gray-900">
                                            <h3 className="font-semibold text-gray-900 dark:text-white">{module.title}</h3>
                                            {module.description && (
                                                <p className="text-sm text-gray-600 dark:text-gray-400 mt-1">{module.description}</p>
                                            )}
                                        </div>

                                        <div className="divide-y divide-gray-100 dark:divide-gray-800">
                                            {module.lessons.map((lesson) => {
                                                const isCompleted = completedLessons.includes(lesson.id);
                                                const isSelected = selectedLesson?.id === lesson.id;

                                                return (
                                                    <button
                                                        key={lesson.id}
                                                        onClick={() => setSelectedLesson(lesson)}
                                                        className={`w-full p-4 text-left hover:bg-purple-50 dark:hover:bg-purple-900/30 transition-colors ${
                                                            isSelected ? 'bg-purple-100 dark:bg-purple-900/50' : ''
                                                        }`}
                                                    >
                                                        <div className="flex items-start space-x-3">
                                                            <div className={`mt-0.5 flex-shrink-0 ${
                                                                isCompleted ? 'text-green-500' : 'text-gray-400'
                                                            }`}>
                                                                <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                            </div>
                                                            <div className="flex-1 min-w-0">
                                                                <p className={`font-medium text-sm ${
                                                                    isSelected ? 'text-purple-600 dark:text-purple-400' : 'text-gray-900 dark:text-white'
                                                                }`}>
                                                                    {lesson.title}
                                                                </p>
                                                                {lesson.description && (
                                                                    <p className="text-xs text-gray-600 dark:text-gray-400 mt-1 line-clamp-1">
                                                                        {lesson.description}
                                                                    </p>
                                                                )}
                                                                {lesson.duration && (
                                                                    <p className="text-xs text-gray-500 dark:text-gray-500 mt-1">
                                                                        {lesson.duration}
                                                                    </p>
                                                                )}
                                                            </div>
                                                        </div>
                                                    </button>
                                                );
                                            })}
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </div>
                </div>

                {/* Review Modal */}
                {showReviewModal && (
                    <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
                        <div className="bg-white dark:bg-gray-800 rounded-xl max-w-md w-full p-6">
                            <div className="flex items-center justify-between mb-4">
                                <h2 className="text-2xl font-bold text-gray-900 dark:text-white">Write a Review</h2>
                                <button
                                    onClick={() => setShowReviewModal(false)}
                                    className="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                >
                                    <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <form onSubmit={handleReviewSubmit}>
                                <div className="mb-4">
                                    <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Rating
                                    </label>
                                    <div className="flex items-center space-x-2">
                                        {[1, 2, 3, 4, 5].map((star) => (
                                            <button
                                                key={star}
                                                type="button"
                                                onClick={() => reviewForm.setData('rating', star)}
                                                className="focus:outline-none transition-transform hover:scale-110"
                                            >
                                                <svg
                                                    className={`w-8 h-8 ${
                                                        star <= reviewForm.data.rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600'
                                                    }`}
                                                    fill="currentColor"
                                                    viewBox="0 0 20 20"
                                                >
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            </button>
                                        ))}
                                    </div>
                                </div>

                                <div className="mb-6">
                                    <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Comment
                                    </label>
                                    <textarea
                                        value={reviewForm.data.comment}
                                        onChange={(e) => reviewForm.setData('comment', e.target.value)}
                                        rows="4"
                                        className="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-gray-700 dark:text-white"
                                        placeholder="Share your experience with this course..."
                                        required
                                    />
                                </div>

                                <div className="flex space-x-3">
                                    <button
                                        type="button"
                                        onClick={() => setShowReviewModal(false)}
                                        className="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                                    >
                                        Cancel
                                    </button>
                                    <button
                                        type="submit"
                                        disabled={reviewForm.processing}
                                        className="flex-1 px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 transition-all disabled:opacity-50"
                                    >
                                        {reviewForm.processing ? 'Submitting...' : 'Submit Review'}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                )}
            </div>
        </StudentLayout>
    );
}
