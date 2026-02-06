import React from 'react';
import { useForm } from '@inertiajs/react';
import StudentLayout from '@/Layouts/StudentLayout';

export default function Profile({ auth }) {
    const { data, setData, put, processing, errors } = useForm({
        name: auth.user.name || '',
        email: auth.user.email || '',
        phone: auth.user.phone || '',
        address: auth.user.address || '',
        password: '',
        password_confirmation: '',
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        put('/student/profile');
    };

    return (
        <StudentLayout auth={auth}>
            <div className="space-y-6">
                {/* Header */}
                <div className="bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl p-8 text-white shadow-xl">
                    <h1 className="text-3xl font-bold mb-2">My Profile</h1>
                    <p className="text-purple-100">Manage your personal information and settings</p>
                </div>

                {/* Profile Card */}
                <div className="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-purple-100 dark:border-purple-800 overflow-hidden">
                    <div className="bg-gradient-to-r from-purple-500 to-pink-500 h-24"></div>
                    <div className="px-8 pb-8">
                        <div className="flex items-end -mt-16 mb-6">
                            <div className="w-32 h-32 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white text-5xl font-bold border-4 border-white dark:border-gray-800 shadow-xl">
                                {auth.user.name?.charAt(0).toUpperCase() || 'U'}
                            </div>
                            <div className="ml-6 mb-4">
                                <h2 className="text-2xl font-bold text-gray-900 dark:text-white">{auth.user.name}</h2>
                                <p className="text-gray-600 dark:text-gray-400">{auth.user.email}</p>
                            </div>
                        </div>

                        <form onSubmit={handleSubmit} className="space-y-6">
                            {/* Personal Information */}
                            <div>
                                <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">Personal Information</h3>
                                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Full Name
                                        </label>
                                        <input
                                            type="text"
                                            value={data.name}
                                            onChange={(e) => setData('name', e.target.value)}
                                            className="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-gray-700 dark:text-white"
                                            required
                                        />
                                        {errors.name && (
                                            <p className="mt-1 text-sm text-red-600 dark:text-red-400">{errors.name}</p>
                                        )}
                                    </div>

                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Email Address
                                        </label>
                                        <input
                                            type="email"
                                            value={data.email}
                                            onChange={(e) => setData('email', e.target.value)}
                                            className="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-gray-700 dark:text-white"
                                            required
                                        />
                                        {errors.email && (
                                            <p className="mt-1 text-sm text-red-600 dark:text-red-400">{errors.email}</p>
                                        )}
                                    </div>

                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Phone Number
                                        </label>
                                        <input
                                            type="tel"
                                            value={data.phone}
                                            onChange={(e) => setData('phone', e.target.value)}
                                            className="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-gray-700 dark:text-white"
                                            placeholder="+880 1XXX-XXXXXX"
                                        />
                                        {errors.phone && (
                                            <p className="mt-1 text-sm text-red-600 dark:text-red-400">{errors.phone}</p>
                                        )}
                                    </div>

                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Address
                                        </label>
                                        <input
                                            type="text"
                                            value={data.address}
                                            onChange={(e) => setData('address', e.target.value)}
                                            className="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-gray-700 dark:text-white"
                                            placeholder="Your address"
                                        />
                                        {errors.address && (
                                            <p className="mt-1 text-sm text-red-600 dark:text-red-400">{errors.address}</p>
                                        )}
                                    </div>
                                </div>
                            </div>

                            {/* Change Password */}
                            <div className="border-t border-gray-200 dark:border-gray-700 pt-6">
                                <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">Change Password</h3>
                                <p className="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                    Leave blank if you don't want to change your password
                                </p>
                                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            New Password
                                        </label>
                                        <input
                                            type="password"
                                            value={data.password}
                                            onChange={(e) => setData('password', e.target.value)}
                                            className="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-gray-700 dark:text-white"
                                            placeholder="••••••••"
                                        />
                                        {errors.password && (
                                            <p className="mt-1 text-sm text-red-600 dark:text-red-400">{errors.password}</p>
                                        )}
                                    </div>

                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Confirm Password
                                        </label>
                                        <input
                                            type="password"
                                            value={data.password_confirmation}
                                            onChange={(e) => setData('password_confirmation', e.target.value)}
                                            className="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-gray-700 dark:text-white"
                                            placeholder="••••••••"
                                        />
                                        {errors.password_confirmation && (
                                            <p className="mt-1 text-sm text-red-600 dark:text-red-400">{errors.password_confirmation}</p>
                                        )}
                                    </div>
                                </div>
                            </div>

                            {/* Account Info */}
                            <div className="border-t border-gray-200 dark:border-gray-700 pt-6">
                                <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">Account Information</h3>
                                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div className="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg">
                                        <p className="text-sm text-gray-600 dark:text-gray-400">Account Type</p>
                                        <p className="font-semibold text-gray-900 dark:text-white capitalize">{auth.user.role}</p>
                                    </div>
                                    <div className="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg">
                                        <p className="text-sm text-gray-600 dark:text-gray-400">Member Since</p>
                                        <p className="font-semibold text-gray-900 dark:text-white">
                                            {new Date(auth.user.created_at).toLocaleDateString('en-US', {
                                                year: 'numeric',
                                                month: 'long',
                                                day: 'numeric'
                                            })}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {/* Actions */}
                            <div className="border-t border-gray-200 dark:border-gray-700 pt-6">
                                <div className="flex items-center justify-end space-x-4">
                                    <a
                                        href="/student/dashboard"
                                        className="px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                                    >
                                        Cancel
                                    </a>
                                    <button
                                        type="submit"
                                        disabled={processing}
                                        className="px-6 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 transition-all disabled:opacity-50 font-semibold"
                                    >
                                        {processing ? 'Saving...' : 'Save Changes'}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {/* Danger Zone */}
                <div className="bg-red-50 dark:bg-red-900/20 rounded-xl p-6 border border-red-200 dark:border-red-800">
                    <h3 className="text-lg font-semibold text-red-900 dark:text-red-400 mb-2">Danger Zone</h3>
                    <p className="text-sm text-red-700 dark:text-red-300 mb-4">
                        Once you delete your account, there is no going back. Please be certain.
                    </p>
                    <button
                        className="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm font-semibold"
                        onClick={() => {
                            if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
                                // Add account deletion logic if needed
                            }
                        }}
                    >
                        Delete Account
                    </button>
                </div>
            </div>
        </StudentLayout>
    );
}
