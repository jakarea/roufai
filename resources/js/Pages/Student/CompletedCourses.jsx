import React from 'react';
import { Link } from '@inertiajs/react';
import StudentLayout from '@/Layouts/StudentLayout';

export default function CompletedCourses({ auth, completedCourses }) {
    return (
        <StudentLayout auth={auth}>
            <div className="space-y-6">
                {/* Header */}
                <div className="bg-gradient-to-r from-green-600 to-teal-600 rounded-2xl p-8 text-white shadow-xl">
                    <h1 className="text-3xl font-bold mb-2">
                        Completed Courses
                    </h1>
                    <p className="text-green-100">
                        Congratulations! You've completed {completedCourses.length} {completedCourses.length === 1 ? 'course' : 'courses'}
                    </p>
                </div>

                {/* Stats Overview */}
                <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-green-100 dark:border-green-800">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-gray-600 dark:text-gray-400 text-sm font-medium">Completed Courses</p>
                                <p className="text-3xl font-bold text-gray-900 dark:text-white mt-2">
                                    {completedCourses.length}
                                </p>
                            </div>
                            <div className="w-12 h-12 bg-gradient-to-br from-green-500 to-teal-500 rounded-lg flex items-center justify-center">
                                <svg className="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-purple-100 dark:border-purple-800">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-gray-600 dark:text-gray-400 text-sm font-medium">Certificates Earned</p>
                                <p className="text-3xl font-bold text-gray-900 dark:text-white mt-2">
                                    {completedCourses.length}
                                </p>
                            </div>
                            <div className="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center">
                                <svg className="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-blue-100 dark:border-blue-800">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-gray-600 dark:text-gray-400 text-sm font-medium">Achievement Rate</p>
                                <p className="text-3xl font-bold text-gray-900 dark:text-white mt-2">
                                    {completedCourses.length > 0 ? '100%' : '0%'}
                                </p>
                            </div>
                            <div className="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-lg flex items-center justify-center">
                                <svg className="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Completed Courses List */}
                <div>
                    <h2 className="text-2xl font-bold text-gray-900 dark:text-white mb-6">Your Certificates</h2>

                    {completedCourses.length === 0 ? (
                        <div className="bg-white dark:bg-gray-800 rounded-xl p-12 text-center shadow-lg border border-green-100 dark:border-green-800">
                            <svg className="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                            <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-2">No completed courses yet</h3>
                            <p className="text-gray-600 dark:text-gray-400">Complete all lessons in a course to earn your certificate!</p>
                        </div>
                    ) : (
                        <div className="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-green-100 dark:border-green-800 overflow-hidden">
                            {/* Table Header */}
                            <div className="grid grid-cols-12 gap-4 px-6 py-4 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600 text-sm font-semibold text-gray-700 dark:text-gray-300">
                                <div className="col-span-1">#</div>
                                <div className="col-span-5">Course Title</div>
                                <div className="col-span-3">Instructor</div>
                                <div className="col-span-2">Completed</div>
                                <div className="col-span-1 text-right">Action</div>
                            </div>

                            {/* Table Rows */}
                            {completedCourses.map((course, index) => (
                                <div
                                    key={course.id}
                                    className="grid grid-cols-12 gap-4 px-6 py-4 border-b border-gray-200 dark:border-gray-700 items-center hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors"
                                >
                                    {/* Index */}
                                    <div className="col-span-1">
                                        <div className="w-8 h-8 bg-gradient-to-br from-green-500 to-teal-500 rounded-full flex items-center justify-center text-white text-sm font-bold">
                                            {index + 1}
                                        </div>
                                    </div>

                                    {/* Course Info */}
                                    <div className="col-span-5">
                                        <div className="flex items-center space-x-3">
                                            {/* Small Thumbnail */}
                                            <div className="w-16 h-16 rounded-lg overflow-hidden flex-shrink-0 bg-gradient-to-br from-green-400 to-teal-400">
                                                {course.thumbnail_path || course.thumbnail_url ? (
                                                    <img
                                                        src={course.thumbnail_path || course.thumbnail_url}
                                                        alt={course.title}
                                                        className="w-full h-full object-cover"
                                                    />
                                                ) : (
                                                    <div className="w-full h-full flex items-center justify-center text-white text-xs">
                                                        <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                        </svg>
                                                    </div>
                                                )}
                                            </div>

                                            <div className="flex-1 min-w-0">
                                                <h3 className="text-sm font-bold text-gray-900 dark:text-white truncate">
                                                    {course.title}
                                                </h3>
                                                <div className="flex items-center space-x-2 mt-1">
                                                    <span className="px-2 py-0.5 bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400 text-xs font-semibold rounded">
                                                        {course.category?.name || 'General'}
                                                    </span>
                                                    <span className="px-2 py-0.5 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 text-xs font-semibold rounded">
                                                        {course.type}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {/* Instructor */}
                                    <div className="col-span-3">
                                        <div className="flex items-center space-x-2">
                                            <div className="w-8 h-8 bg-gradient-to-br from-green-500 to-teal-500 rounded-full flex items-center justify-center text-white text-xs font-semibold">
                                                {course.instructor?.name?.charAt(0) || 'I'}
                                            </div>
                                            <div>
                                                <p className="text-sm font-medium text-gray-900 dark:text-white">
                                                    {course.instructor?.name || 'Instructor'}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    {/* Completed Date */}
                                    <div className="col-span-2">
                                        <div className="flex items-center space-x-1 text-xs text-gray-500 dark:text-gray-400">
                                            <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span>{course.completed_at ? new Date(course.completed_at).toLocaleDateString() : 'Recently'}</span>
                                        </div>
                                    </div>

                                    {/* Action Button */}
                                    <div className="col-span-1 text-right">
                                        <a
                                            href={`/student/certificate/${course.id}`}
                                            className="inline-flex items-center justify-center w-10 h-10 bg-gradient-to-r from-green-600 to-teal-600 text-white rounded-lg hover:from-green-700 hover:to-teal-700 transition-all shadow-md hover:shadow-lg"
                                            title="Download Certificate"
                                        >
                                            <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            ))}
                        </div>
                    )}
                </div>
            </div>
        </StudentLayout>
    );
}
