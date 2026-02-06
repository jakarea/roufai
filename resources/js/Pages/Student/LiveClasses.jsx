import React, { useState, useEffect } from 'react';
import { Link } from '@inertiajs/react';
import StudentLayout from '@/Layouts/StudentLayout';

export default function LiveClasses({ auth, liveClasses }) {
    const [countdowns, setCountdowns] = useState({});

    // Update countdowns every second
    useEffect(() => {
        const calculateCountdowns = () => {
            const newCountdowns = {};

            liveClasses.forEach((liveClass) => {
                if (liveClass.status !== 'scheduled') {
                    return;
                }

                const [day, month, year] = liveClass.start_date.split('-');
                const [startHours, startMinutes] = liveClass.start_time.split(':');

                const classDate = new Date(year, month - 1, day, startHours, startMinutes);
                const now = new Date();
                const diff = classDate - now;

                if (diff <= 0) {
                    newCountdowns[liveClass.id] = { days: 0, hours: 0, minutes: 0, seconds: 0 };
                    return;
                }

                const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                newCountdowns[liveClass.id] = { days, hours, minutes, seconds };
            });

            setCountdowns(newCountdowns);
        };

        calculateCountdowns();
        const interval = setInterval(calculateCountdowns, 1000);

        return () => clearInterval(interval);
    }, [liveClasses]);

    // Format date time
    const formatDateTime = (date, time) => {
        if (!date || !time) return '';
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

    // Get status badge style
    const getStatusBadge = (status) => {
        switch (status) {
            case 'live':
                return (
                    <span className="px-3 py-1 bg-red-500 text-white text-xs font-bold rounded-full animate-pulse flex items-center space-x-1">
                        <span className="w-2 h-2 bg-white rounded-full"></span>
                        <span>LIVE NOW</span>
                    </span>
                );
            case 'scheduled':
                return (
                    <span className="px-3 py-1 bg-blue-500 text-white text-xs font-semibold rounded-full">
                        Upcoming
                    </span>
                );
            case 'completed':
                return (
                    <span className="px-3 py-1 bg-gray-500 text-white text-xs font-semibold rounded-full">
                        Completed
                    </span>
                );
            default:
                return null;
        }
    };

    return (
        <StudentLayout auth={auth}>
            <div className="space-y-6">
                {/* Header */}
                <div className="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl p-8 text-white shadow-xl">
                    <h1 className="text-3xl font-bold mb-2">Live Classes</h1>
                    <p className="text-blue-100">
                        Join live sessions and learn in real-time
                    </p>
                </div>

                {/* Live Classes List */}
                {liveClasses.length === 0 ? (
                    <div className="bg-white dark:bg-gray-800 rounded-xl p-12 text-center shadow-lg border border-purple-100 dark:border-purple-800">
                        <svg className="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-2">No live classes</h3>
                        <p className="text-gray-600 dark:text-gray-400">There are no live classes available at the moment.</p>
                    </div>
                ) : (
                    <div className="space-y-4">
                        {liveClasses.map((liveClass) => (
                            <div
                                key={liveClass.id}
                                className={`bg-white dark:bg-gray-800 rounded-xl shadow-lg border-2 overflow-hidden ${
                                    liveClass.status === 'live'
                                        ? 'border-red-300'
                                        : liveClass.status === 'scheduled'
                                        ? 'border-blue-300'
                                        : 'border-gray-300'
                                }`}
                            >
                                <div className="p-6">
                                    <div className="flex items-start justify-between">
                                        <div className="flex items-start space-x-4 flex-1">
                                            {/* Thumbnail */}
                                            <div className="w-24 h-24 rounded-lg bg-gradient-to-br from-blue-400 to-purple-400 flex-shrink-0 overflow-hidden">
                                                {liveClass.thumbnail_url ? (
                                                    <img
                                                        src={liveClass.thumbnail_url}
                                                        alt={liveClass.topic}
                                                        className="w-full h-full object-cover"
                                                    />
                                                ) : (
                                                    <div className="w-full h-full flex items-center justify-center text-white">
                                                        <svg className="w-10 h-10" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                                                        </svg>
                                                    </div>
                                                )}
                                            </div>

                                            {/* Content */}
                                            <div className="flex-1">
                                                <div className="flex items-center space-x-2 mb-2">
                                                    {getStatusBadge(liveClass.status)}
                                                    {liveClass.course && (
                                                        <span className="px-2 py-1 bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-400 text-xs font-semibold rounded">
                                                            {liveClass.course.title}
                                                        </span>
                                                    )}
                                                </div>

                                                <h3 className="text-xl font-bold text-gray-900 dark:text-white mb-2">
                                                    {liveClass.topic}
                                                </h3>

                                                {liveClass.description && (
                                                    <p className="text-gray-600 dark:text-gray-400 text-sm mb-3 line-clamp-2">
                                                        {liveClass.description}
                                                    </p>
                                                )}

                                                <div className="flex items-center space-x-4 text-sm text-gray-600 dark:text-gray-400">
                                                    <div className="flex items-center space-x-1">
                                                        <svg className="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 8zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clipRule="evenodd" />
                                                        </svg>
                                                        <span>{formatDateTime(liveClass.start_date, liveClass.start_time)}</span>
                                                    </div>
                                                    <div className="flex items-center space-x-1">
                                                        <svg className="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 8zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clipRule="evenodd" />
                                                        </svg>
                                                        <span>{liveClass.duration_minutes} min</span>
                                                    </div>
                                                    <div className="flex items-center space-x-1">
                                                        <svg className="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                                                        </svg>
                                                        <span>{liveClass.instructor.name}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {/* Actions */}
                                        <div className="flex flex-col items-end space-y-3">
                                            {liveClass.status === 'scheduled' && countdowns[liveClass.id] && (
                                                <div className="text-right">
                                                    <div className="text-gray-600 dark:text-gray-400 text-xs mb-1">Starting in:</div>
                                                    <div className="flex items-center space-x-1 font-mono font-bold text-gray-900 dark:text-white">
                                                        {countdowns[liveClass.id].days > 0 && (
                                                            <>
                                                                <span className="bg-blue-100 dark:bg-blue-900 px-2 py-1 rounded text-sm">
                                                                    {countdowns[liveClass.id].days}d
                                                                </span>
                                                                <span>:</span>
                                                            </>
                                                        )}
                                                        <span className="bg-blue-100 dark:bg-blue-900 px-2 py-1 rounded text-sm">
                                                            {String(countdowns[liveClass.id].hours).padStart(2, '0')}h
                                                        </span>
                                                        <span>:</span>
                                                        <span className="bg-blue-100 dark:bg-blue-900 px-2 py-1 rounded text-sm">
                                                            {String(countdowns[liveClass.id].minutes).padStart(2, '0')}m
                                                        </span>
                                                        <span>:</span>
                                                        <span className="bg-blue-100 dark:bg-blue-900 px-2 py-1 rounded text-sm">
                                                            {String(countdowns[liveClass.id].seconds).padStart(2, '0')}s
                                                        </span>
                                                    </div>
                                                </div>
                                            )}

                                            {liveClass.status !== 'completed' && (
                                                <a
                                                    href={liveClass.meeting_link}
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    className={`px-6 py-2 rounded-lg font-bold shadow-lg transition-all duration-300 hover:scale-105 flex items-center space-x-2 ${
                                                        liveClass.status === 'live'
                                                            ? 'bg-red-500 text-white hover:bg-red-600'
                                                            : 'bg-blue-500 text-white hover:bg-blue-600'
                                                    }`}
                                                >
                                                    <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                                                    </svg>
                                                    <span>{liveClass.status === 'live' ? 'Join Now' : 'Join Class'}</span>
                                                </a>
                                            )}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>
                )}
            </div>
        </StudentLayout>
    );
}
