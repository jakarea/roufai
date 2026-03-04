import React, { useState } from 'react';
import { useForm, usePage } from '@inertiajs/react';
import StudentLayout from '@/Layouts/StudentLayout';

export default function Profile({ auth }) {
    const { flash } = usePage().props;
    const [showPasswordForm, setShowPasswordForm] = useState(false);
    const [avatarPreview, setAvatarPreview] = useState(auth.user.avatar_url || null);

    // Profile form
    const { data, setData, put, processing: profileProcessing, errors: profileErrors } = useForm({
        name: auth.user.name || '',
        email: auth.user.email || '',
        phone: auth.user.phone || '',
        address: auth.user.address || '',
        avatar: null,
    });

    // Password form
    const { data: passwordData, setData: setPasswordData, put: putPassword, processing: passwordProcessing, errors: passwordErrors, reset: resetPassword } = useForm({
        current_password: '',
        password: '',
        password_confirmation: '',
    });

    const handleProfileSubmit = (e) => {
        e.preventDefault();

        // If there's an avatar, use FormData
        if (data.avatar) {
            const formData = new FormData();
            formData.append('name', data.name);
            formData.append('email', data.email);
            formData.append('phone', data.phone || '');
            formData.append('address', data.address || '');
            formData.append('avatar', data.avatar);

            router.post('/student/profile', formData, {
                forceFormData: true,
                onSuccess: () => {
                    window.location.reload();
                },
            });
        } else {
            // No avatar, regular form submission
            put('/student/profile');
        }
    };

    const handlePasswordSubmit = (e) => {
        e.preventDefault();
        putPassword('/student/password', {
            onSuccess: () => {
                resetPassword();
                setShowPasswordForm(false);
            },
        });
    };

    const handleAvatarChange = (e) => {
        const file = e.target.files[0];
        if (file) {
            setData('avatar', file);
            setAvatarPreview(URL.createObjectURL(file));
        }
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

                {/* Header */}
                <div className="bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl p-8 text-white shadow-xl">
                    <h1 className="text-3xl font-bold mb-2">My Profile</h1>
                    <p className="text-purple-100">Manage your personal information and settings</p>
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {/* Left Column - Avatar Card */}
                    <div className="lg:col-span-1">
                        <div className="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-purple-100 dark:border-purple-800 p-6">
                            <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">Profile Picture</h3>

                            <div className="flex flex-col items-center">
                                {/* Avatar Preview */}
                                <div className="relative mb-4">
                                    <div className="w-32 h-32 rounded-full overflow-hidden border-4 border-purple-200 dark:border-purple-700 shadow-lg">
                                        {avatarPreview ? (
                                            <img
                                                src={avatarPreview}
                                                alt="Profile"
                                                className="w-full h-full object-cover"
                                            />
                                        ) : (
                                            <div className="w-full h-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white text-5xl font-bold">
                                                {auth.user.name?.charAt(0).toUpperCase() || 'U'}
                                            </div>
                                        )}
                                    </div>
                                    <label
                                        htmlFor="avatar-upload"
                                        className="absolute bottom-0 right-0 bg-purple-600 hover:bg-purple-700 text-white p-2 rounded-full cursor-pointer shadow-lg transition-colors"
                                    >
                                        <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </label>
                                    <input
                                        id="avatar-upload"
                                        type="file"
                                        accept="image/*"
                                        onChange={handleAvatarChange}
                                        className="hidden"
                                    />
                                </div>

                                <p className="text-sm text-gray-600 dark:text-gray-400 text-center mb-4">
                                    Upload a new avatar (JPG, PNG, GIF - Max 2MB)
                                </p>

                                {data.avatar && (
                                    <div className="w-full text-center">
                                        <p className="text-sm text-gray-700 dark:text-gray-300 mb-2">
                                            Selected: {data.avatar.name}
                                        </p>
                                        <button
                                            type="button"
                                            onClick={() => {
                                                setData('avatar', null);
                                                setAvatarPreview(auth.user.avatar_url || null);
                                            }}
                                            className="text-sm text-red-600 hover:text-red-700"
                                        >
                                            Remove
                                        </button>
                                    </div>
                                )}
                            </div>
                        </div>

                        {/* Account Info Card */}
                        <div className="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-purple-100 dark:border-purple-800 p-6 mt-6">
                            <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">Account Information</h3>
                            <div className="space-y-3">
                                <div className="bg-gray-50 dark:bg-gray-900 p-3 rounded-lg">
                                    <p className="text-xs text-gray-600 dark:text-gray-400">Account Type</p>
                                    <p className="font-semibold text-gray-900 dark:text-white capitalize">{auth.user.role}</p>
                                </div>
                                <div className="bg-gray-50 dark:bg-gray-900 p-3 rounded-lg">
                                    <p className="text-xs text-gray-600 dark:text-gray-400">Member Since</p>
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
                    </div>

                    {/* Right Column - Forms */}
                    <div className="lg:col-span-2 space-y-6">
                        {/* Personal Information Form */}
                        <div className="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-purple-100 dark:border-purple-800 p-6">
                            <h3 className="text-lg font-semibold text-gray-900 dark:text-white mb-4">Personal Information</h3>

                            <form onSubmit={handleProfileSubmit} className="space-y-4">
                                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Full Name <span className="text-red-500">*</span>
                                        </label>
                                        <input
                                            type="text"
                                            value={data.name}
                                            onChange={(e) => setData('name', e.target.value)}
                                            className="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-gray-700 dark:text-white"
                                            required
                                        />
                                        {profileErrors.name && (
                                            <p className="mt-1 text-sm text-red-600 dark:text-red-400">{profileErrors.name}</p>
                                        )}
                                    </div>

                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Email Address <span className="text-red-500">*</span>
                                        </label>
                                        <input
                                            type="email"
                                            value={data.email}
                                            onChange={(e) => setData('email', e.target.value)}
                                            className="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-gray-700 dark:text-white"
                                            required
                                        />
                                        {profileErrors.email && (
                                            <p className="mt-1 text-sm text-red-600 dark:text-red-400">{profileErrors.email}</p>
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
                                        {profileErrors.phone && (
                                            <p className="mt-1 text-sm text-red-600 dark:text-red-400">{profileErrors.phone}</p>
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
                                        {profileErrors.address && (
                                            <p className="mt-1 text-sm text-red-600 dark:text-red-400">{profileErrors.address}</p>
                                        )}
                                    </div>
                                </div>

                                <div className="flex items-center justify-end pt-4 border-t border-gray-200 dark:border-gray-700">
                                    <button
                                        type="submit"
                                        disabled={profileProcessing}
                                        className="px-6 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 transition-all disabled:opacity-50 font-semibold"
                                    >
                                        {profileProcessing ? 'Saving...' : 'Save Changes'}
                                    </button>
                                </div>
                            </form>
                        </div>

                        {/* Change Password Section */}
                        <div className="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-purple-100 dark:border-purple-800 p-6">
                            <div className="flex items-center justify-between mb-4">
                                <h3 className="text-lg font-semibold text-gray-900 dark:text-white">Change Password</h3>
                                {!showPasswordForm && (
                                    <button
                                        onClick={() => setShowPasswordForm(true)}
                                        className="text-sm text-purple-600 hover:text-purple-700 font-medium"
                                    >
                                        Change Password
                                    </button>
                                )}
                            </div>

                            {showPasswordForm ? (
                                <form onSubmit={handlePasswordSubmit} className="space-y-4">
                                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Current Password <span className="text-red-500">*</span>
                                            </label>
                                            <input
                                                type="password"
                                                value={passwordData.current_password}
                                                onChange={(e) => setPasswordData('current_password', e.target.value)}
                                                className="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-gray-700 dark:text-white"
                                                required
                                            />
                                            {passwordErrors.current_password && (
                                                <p className="mt-1 text-sm text-red-600 dark:text-red-400">{passwordErrors.current_password}</p>
                                            )}
                                        </div>

                                        <div></div>

                                        <div>
                                            <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                New Password <span className="text-red-500">*</span>
                                            </label>
                                            <input
                                                type="password"
                                                value={passwordData.password}
                                                onChange={(e) => setPasswordData('password', e.target.value)}
                                                className="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-gray-700 dark:text-white"
                                                placeholder="Min. 8 characters"
                                                required
                                            />
                                            {passwordErrors.password && (
                                                <p className="mt-1 text-sm text-red-600 dark:text-red-400">{passwordErrors.password}</p>
                                            )}
                                        </div>

                                        <div>
                                            <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Confirm New Password <span className="text-red-500">*</span>
                                            </label>
                                            <input
                                                type="password"
                                                value={passwordData.password_confirmation}
                                                onChange={(e) => setPasswordData('password_confirmation', e.target.value)}
                                                className="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-gray-700 dark:text-white"
                                                placeholder="Confirm password"
                                                required
                                            />
                                            {passwordErrors.password_confirmation && (
                                                <p className="mt-1 text-sm text-red-600 dark:text-red-400">{passwordErrors.password_confirmation}</p>
                                            )}
                                        </div>
                                    </div>

                                    <div className="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                                        <button
                                            type="button"
                                            onClick={() => {
                                                setShowPasswordForm(false);
                                                resetPassword();
                                            }}
                                            className="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                                        >
                                            Cancel
                                        </button>
                                        <button
                                            type="submit"
                                            disabled={passwordProcessing}
                                            className="px-6 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 transition-all disabled:opacity-50 font-semibold"
                                        >
                                            {passwordProcessing ? 'Updating...' : 'Update Password'}
                                        </button>
                                    </div>
                                </form>
                            ) : (
                                <p className="text-sm text-gray-600 dark:text-gray-400">
                                    Click "Change Password" to update your password. You'll need to enter your current password for security.
                                </p>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </StudentLayout>
    );
}
