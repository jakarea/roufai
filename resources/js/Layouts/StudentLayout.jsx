import React from 'react';
import { Link } from '@inertiajs/react';
import { useState, useEffect } from 'react';

export default function StudentLayout({ children, auth }) {
    const [darkMode, setDarkMode] = useState(false);

    useEffect(() => {
        // Check for dark mode preference
        if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
            setDarkMode(true);
        }
    }, []);

    const toggleDarkMode = () => {
        setDarkMode(!darkMode);
        if (!darkMode) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    };

    return (
        <div className={`min-h-screen ${darkMode ? 'dark' : ''}`}>
            <div className="min-h-screen bg-gray-50 dark:bg-gray-900">
                {/* Top Navigation */}
                <nav className="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="flex justify-between items-center h-16">
                            {/* Logo */}
                            <div className="flex items-center">
                                <Link href="/" className="flex items-center space-x-3">
                                    <div className="w-10 h-10 bg-gray-900 dark:bg-white rounded-lg flex items-center justify-center">
                                        <span className="text-white dark:text-gray-900 font-bold text-xl">R</span>
                                    </div>
                                    <span className="text-2xl font-bold text-gray-900 dark:text-white">
                                        Rouf AI LMS
                                    </span>
                                </Link>
                            </div>

                            {/* Navigation Links */}
                            <div className="hidden md:flex items-center space-x-8">
                                <Link
                                    href="/student/dashboard"
                                    className="text-gray-700 dark:text-gray-200 hover:text-purple-600 dark:hover:text-purple-400 font-medium transition-colors"
                                >
                                    Dashboard
                                </Link>
                                <Link
                                    href="/student/profile"
                                    className="text-gray-700 dark:text-gray-200 hover:text-purple-600 dark:hover:text-purple-400 font-medium transition-colors"
                                >
                                    Profile
                                </Link>
                            </div>

                            {/* Right Side - User Menu */}
                            <div className="flex items-center space-x-4">
                                <button
                                    onClick={toggleDarkMode}
                                    className="p-2 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-purple-100 dark:hover:bg-purple-800 transition-colors"
                                >
                                    {darkMode ? (
                                        <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fillRule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clipRule="evenodd" />
                                        </svg>
                                    ) : (
                                        <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                                        </svg>
                                    )}
                                </button>

                                <div className="relative group">
                                    <button className="flex items-center space-x-3 p-2 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-800 transition-colors">
                                        <div className="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-semibold">
                                            {auth?.user?.name?.charAt(0).toUpperCase() || 'U'}
                                        </div>
                                        <span className="hidden md:block text-sm font-medium text-gray-700 dark:text-gray-200">
                                            {auth?.user?.name || 'User'}
                                        </span>
                                    </button>

                                    {/* Dropdown Menu */}
                                    <div className="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-purple-100 dark:border-purple-800 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                        <div className="py-2">
                                            <div className="px-4 py-2 border-b border-gray-100 dark:border-gray-700">
                                                <p className="text-sm font-semibold text-gray-900 dark:text-white">{auth?.user?.name}</p>
                                                <p className="text-xs text-gray-500 dark:text-gray-400">{auth?.user?.email}</p>
                                            </div>
                                            <Link
                                                href="/student/profile"
                                                className="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-purple-50 dark:hover:bg-purple-900/50"
                                            >
                                                Profile
                                            </Link>
                                            <Link
                                                href="/logout"
                                                method="post"
                                                className="block px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/50"
                                            >
                                                Logout
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>

                {/* Main Content */}
                <main className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    {children}
                </main>

                {/* Footer */}
                <footer className="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md border-t border-purple-100 dark:border-purple-800 mt-12">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                        <div className="text-center text-gray-600 dark:text-gray-400">
                            <p>&copy; {new Date().getFullYear()} Rouf AI LMS. All rights reserved.</p>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    );
}
