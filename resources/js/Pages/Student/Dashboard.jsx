import React from 'react';
import { Link } from '@inertiajs/react';
import StudentLayout from '@/Layouts/StudentLayout';

export default function Dashboard({ auth, enrollments }) {
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

                {/* Stats Overview */}
                <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-purple-100 dark:border-purple-800">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-gray-600 dark:text-gray-400 text-sm font-medium">Enrolled Courses</p>
                                <p className="text-3xl font-bold text-gray-900 dark:text-white mt-2">
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

                    <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-purple-100 dark:border-purple-800">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-gray-600 dark:text-gray-400 text-sm font-medium">Total Learning Time</p>
                                <p className="text-3xl font-bold text-gray-900 dark:text-white mt-2">
                                    0h
                                </p>
                            </div>
                            <div className="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-500 rounded-lg flex items-center justify-center">
                                <svg className="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-purple-100 dark:border-purple-800">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-gray-600 dark:text-gray-400 text-sm font-medium">Certificates Earned</p>
                                <p className="text-3xl font-bold text-gray-900 dark:text-white mt-2">
                                    0
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
                    <h2 className="text-2xl font-bold text-gray-900 dark:text-white mb-6">My Enrolled Courses</h2>

                    {enrollments.length === 0 ? (
                        <div className="bg-white dark:bg-gray-800 rounded-xl p-12 text-center shadow-lg border border-purple-100 dark:border-purple-800">
                            <svg className="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-2">No courses yet</h3>
                            <p className="text-gray-600 dark:text-gray-400">You haven't enrolled in any courses yet.</p>
                        </div>
                    ) : (
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            {enrollments.map((enrollment) => (
                                <Link
                                    key={enrollment.id}
                                    href={`/student/courses/${enrollment.course.id}`}
                                    className="group"
                                >
                                    <div className="bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-lg border border-purple-100 dark:border-purple-800 transition-all duration-300 hover:shadow-2xl hover:scale-105">
                                        {/* Course Thumbnail */}
                                        <div className="relative h-48 bg-gradient-to-br from-purple-400 to-pink-400">
                                            {enrollment.course.thumbnail_url ? (
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
                                            <div className="absolute top-3 right-3">
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
                                            <div className="flex items-center space-x-2 mb-2">
                                                <span className="px-2 py-1 bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-400 text-xs font-semibold rounded">
                                                    {enrollment.course.category?.name || 'General'}
                                                </span>
                                            </div>

                                            <h3 className="text-lg font-bold text-gray-900 dark:text-white mb-2 line-clamp-2 group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">
                                                {enrollment.course.title}
                                            </h3>

                                            <p className="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">
                                                {enrollment.course.description}
                                            </p>

                                            <div className="flex items-center justify-between pt-3 border-t border-gray-200 dark:border-gray-700">
                                                <div className="flex items-center space-x-2">
                                                    <div className="w-6 h-6 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white text-xs font-semibold">
                                                        {enrollment.course.instructor?.name?.charAt(0) || 'I'}
                                                    </div>
                                                    <span className="text-xs text-gray-600 dark:text-gray-400">
                                                        {enrollment.course.instructor?.name || 'Instructor'}
                                                    </span>
                                                </div>
                                                <span className="text-xs text-gray-500 dark:text-gray-500">
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
