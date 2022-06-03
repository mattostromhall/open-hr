<script setup lang="ts">

</script>

<template>
    <div class="p-8 lg:grid lg:grid-cols-12 lg:gap-x-5">
        <aside class="py-6 px-2 sm:px-6 lg:col-span-3 lg:p-0">
            <nav class="space-y-1">
                <!-- Current: "bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white", Default: "text-gray-900 hover:text-gray-900 hover:bg-gray-50" -->
                <a
                    href="#"
                    class="group flex items-center py-2 px-3 text-sm font-medium text-indigo-700 hover:text-indigo-700 bg-gray-50 hover:bg-white rounded-md"
                    aria-current="page"
                >
                    <!--
                      Heroicon name: outline/user-circle

                      Current: "text-indigo-500 group-hover:text-indigo-500", Default: "text-gray-400 group-hover:text-gray-500"
                    -->
                    <svg
                        class="shrink-0 mr-3 -ml-1 w-6 h-6 text-indigo-500 group-hover:text-indigo-500"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        aria-hidden="true"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>
                    <span class="truncate"> Account </span>
                </a>

                <a
                    href="#"
                    class="group flex items-center py-2 px-3 text-sm font-medium text-gray-900 hover:text-gray-900 hover:bg-gray-50 rounded-md"
                >
                    <!-- Heroicon name: outline/key -->
                    <svg
                        class="shrink-0 mr-3 -ml-1 w-6 h-6 text-gray-400 group-hover:text-gray-500"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        aria-hidden="true"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"
                        />
                    </svg>
                    <span class="truncate"> Password </span>
                </a>

                <a
                    href="#"
                    class="group flex items-center py-2 px-3 text-sm font-medium text-gray-900 hover:text-gray-900 hover:bg-gray-50 rounded-md"
                >
                    <!-- Heroicon name: outline/credit-card -->
                    <svg
                        class="shrink-0 mr-3 -ml-1 w-6 h-6 text-gray-400 group-hover:text-gray-500"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        aria-hidden="true"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"
                        />
                    </svg>
                    <span class="truncate"> Plan &amp; Billing </span>
                </a>

                <a
                    href="#"
                    class="group flex items-center py-2 px-3 text-sm font-medium text-gray-900 hover:text-gray-900 hover:bg-gray-50 rounded-md"
                >
                    <!-- Heroicon name: outline/user-group -->
                    <svg
                        class="shrink-0 mr-3 -ml-1 w-6 h-6 text-gray-400 group-hover:text-gray-500"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        aria-hidden="true"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                        />
                    </svg>
                    <span class="truncate"> Team </span>
                </a>

                <a
                    href="#"
                    class="group flex items-center py-2 px-3 text-sm font-medium text-gray-900 hover:text-gray-900 hover:bg-gray-50 rounded-md"
                >
                    <!-- Heroicon name: outline/view-grid-add -->
                    <svg
                        class="shrink-0 mr-3 -ml-1 w-6 h-6 text-gray-400 group-hover:text-gray-500"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        aria-hidden="true"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z"
                        />
                    </svg>
                    <span class="truncate"> Integrations </span>
                </a>
            </nav>
        </aside>

        <div class="space-y-6 sm:px-6 lg:col-span-9 lg:px-0">
            <form
                action="#"
                method="POST"
            >
                <div class="shadow sm:overflow-hidden sm:rounded-md">
                    <div class="py-6 px-4 space-y-6 bg-white sm:p-6">
                        <div>
                            <h3 class="text-lg font-medium leading-6 text-gray-900">
                                Profile
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">
                                This information will be displayed publicly so be careful what you share.
                            </p>
                        </div>

                        <div class="grid grid-cols-3 gap-6">
                            <div class="col-span-3 sm:col-span-2">
                                <label
                                    for="company-website"
                                    class="block text-sm font-medium text-gray-700"
                                > Username </label>
                                <div class="flex mt-1 rounded-md shadow-sm">
                                    <span class="inline-flex items-center px-3 text-gray-500 bg-gray-50 rounded-l-md border border-r-0 border-gray-300 sm:text-sm"> workcation.com/ </span>
                                    <input
                                        id="username"
                                        type="text"
                                        name="username"
                                        autocomplete="username"
                                        class="block grow w-full min-w-0 rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    >
                                </div>
                            </div>

                            <div class="col-span-3">
                                <label
                                    for="about"
                                    class="block text-sm font-medium text-gray-700"
                                > About </label>
                                <div class="mt-1">
                                    <textarea
                                        id="about"
                                        name="about"
                                        rows="3"
                                        class="block mt-1 w-full rounded-md border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm sm:text-sm"
                                        placeholder="you@example.com"
                                    />
                                </div>
                                <p class="mt-2 text-sm text-gray-500">
                                    Brief description for your profile. URLs are hyperlinked.
                                </p>
                            </div>

                            <div class="col-span-3">
                                <label class="block text-sm font-medium text-gray-700"> Photo </label>
                                <div class="flex items-center mt-1">
                                    <span class="inline-block overflow-hidden w-12 h-12 bg-gray-100 rounded-full">
                                        <svg
                                            class="w-full h-full text-gray-300"
                                            fill="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </span>
                                    <button
                                        type="button"
                                        class="py-2 px-3 ml-5 text-sm font-medium leading-4 text-gray-700 bg-white hover:bg-gray-50 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 shadow-sm"
                                    >
                                        Change
                                    </button>
                                </div>
                            </div>

                            <div class="col-span-3">
                                <label class="block text-sm font-medium text-gray-700"> Cover photo </label>
                                <div class="flex justify-center px-6 pt-5 pb-6 mt-1 rounded-md border-2 border-gray-300 border-dashed">
                                    <div class="space-y-1 text-center">
                                        <svg
                                            class="mx-auto w-12 h-12 text-gray-400"
                                            stroke="currentColor"
                                            fill="none"
                                            viewBox="0 0 48 48"
                                            aria-hidden="true"
                                        >
                                            <path
                                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label
                                                for="file-upload"
                                                class="relative font-medium text-indigo-600 hover:text-indigo-500 bg-white rounded-md focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 cursor-pointer"
                                            >
                                                <span>Upload a file</span>
                                                <input
                                                    id="file-upload"
                                                    name="file-upload"
                                                    type="file"
                                                    class="sr-only"
                                                >
                                            </label>
                                            <p class="pl-1">
                                                or drag and drop
                                            </p>
                                        </div>
                                        <p class="text-xs text-gray-500">
                                            PNG, JPG, GIF up to 10MB
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="py-3 px-4 text-right bg-gray-50 sm:px-6">
                        <button
                            type="submit"
                            class="inline-flex justify-center py-2 px-4 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md border border-transparent focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 shadow-sm"
                        >
                            Save
                        </button>
                    </div>
                </div>
            </form>

            <form
                action="#"
                method="POST"
            >
                <div class="shadow sm:overflow-hidden sm:rounded-md">
                    <div class="py-6 px-4 space-y-6 bg-white sm:p-6">
                        <div>
                            <h3 class="text-lg font-medium leading-6 text-gray-900">
                                Personal Information
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Use a permanent address where you can recieve mail.
                            </p>
                        </div>

                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <label
                                    for="first-name"
                                    class="block text-sm font-medium text-gray-700"
                                >First name</label>
                                <input
                                    id="first-name"
                                    type="text"
                                    name="first-name"
                                    autocomplete="given-name"
                                    class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 shadow-sm sm:text-sm"
                                >
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label
                                    for="last-name"
                                    class="block text-sm font-medium text-gray-700"
                                >Last name</label>
                                <input
                                    id="last-name"
                                    type="text"
                                    name="last-name"
                                    autocomplete="family-name"
                                    class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 shadow-sm sm:text-sm"
                                >
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <label
                                    for="email-address"
                                    class="block text-sm font-medium text-gray-700"
                                >Email address</label>
                                <input
                                    id="email-address"
                                    type="text"
                                    name="email-address"
                                    autocomplete="email"
                                    class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 shadow-sm sm:text-sm"
                                >
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label
                                    for="country"
                                    class="block text-sm font-medium text-gray-700"
                                >Country</label>
                                <select
                                    id="country"
                                    name="country"
                                    autocomplete="country-name"
                                    class="block py-2 px-3 mt-1 w-full bg-white rounded-md border border-gray-300 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 shadow-sm sm:text-sm"
                                >
                                    <option>United States</option>
                                    <option>Canada</option>
                                    <option>Mexico</option>
                                </select>
                            </div>

                            <div class="col-span-6">
                                <label
                                    for="street-address"
                                    class="block text-sm font-medium text-gray-700"
                                >Street address</label>
                                <input
                                    id="street-address"
                                    type="text"
                                    name="street-address"
                                    autocomplete="street-address"
                                    class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 shadow-sm sm:text-sm"
                                >
                            </div>

                            <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                <label
                                    for="city"
                                    class="block text-sm font-medium text-gray-700"
                                >City</label>
                                <input
                                    id="city"
                                    type="text"
                                    name="city"
                                    autocomplete="address-level2"
                                    class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 shadow-sm sm:text-sm"
                                >
                            </div>

                            <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                <label
                                    for="region"
                                    class="block text-sm font-medium text-gray-700"
                                >State / Province</label>
                                <input
                                    id="region"
                                    type="text"
                                    name="region"
                                    autocomplete="address-level1"
                                    class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 shadow-sm sm:text-sm"
                                >
                            </div>

                            <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                <label
                                    for="postal-code"
                                    class="block text-sm font-medium text-gray-700"
                                >ZIP / Postal code</label>
                                <input
                                    id="postal-code"
                                    type="text"
                                    name="postal-code"
                                    autocomplete="postal-code"
                                    class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 shadow-sm sm:text-sm"
                                >
                            </div>
                        </div>
                    </div>
                    <div class="py-3 px-4 text-right bg-gray-50 sm:px-6">
                        <button
                            type="submit"
                            class="inline-flex justify-center py-2 px-4 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md border border-transparent focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 shadow-sm"
                        >
                            Save
                        </button>
                    </div>
                </div>
            </form>

            <form
                action="#"
                method="POST"
            >
                <div class="shadow sm:overflow-hidden sm:rounded-md">
                    <div class="py-6 px-4 space-y-6 bg-white sm:p-6">
                        <div>
                            <h3 class="text-lg font-medium leading-6 text-gray-900">
                                Notifications
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Provide basic informtion about the job. Be specific with the job title.
                            </p>
                        </div>

                        <fieldset>
                            <legend class="text-base font-medium text-gray-900">
                                By Email
                            </legend>
                            <div class="mt-4 space-y-4">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input
                                            id="comments"
                                            name="comments"
                                            type="checkbox"
                                            class="w-4 h-4 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500"
                                        >
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label
                                            for="comments"
                                            class="font-medium text-gray-700"
                                        >Comments</label>
                                        <p class="text-gray-500">
                                            Get notified when someones posts a comment on a posting.
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input
                                                id="candidates"
                                                name="candidates"
                                                type="checkbox"
                                                class="w-4 h-4 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500"
                                            >
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label
                                                for="candidates"
                                                class="font-medium text-gray-700"
                                            >Candidates</label>
                                            <p class="text-gray-500">
                                                Get notified when a candidate applies for a job.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input
                                                id="offers"
                                                name="offers"
                                                type="checkbox"
                                                class="w-4 h-4 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500"
                                            >
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label
                                                for="offers"
                                                class="font-medium text-gray-700"
                                            >Offers</label>
                                            <p class="text-gray-500">
                                                Get notified when a candidate accepts or rejects an offer.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="mt-6">
                            <legend class="text-base font-medium text-gray-900">
                                Push Notifications
                            </legend>
                            <p class="text-sm text-gray-500">
                                These are delivered via SMS to your mobile phone.
                            </p>
                            <div class="mt-4 space-y-4">
                                <div class="flex items-center">
                                    <input
                                        id="push-everything"
                                        name="push-notifications"
                                        type="radio"
                                        class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
                                    >
                                    <label
                                        for="push-everything"
                                        class="ml-3"
                                    >
                                        <span class="block text-sm font-medium text-gray-700">Everything</span>
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input
                                        id="push-email"
                                        name="push-notifications"
                                        type="radio"
                                        class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
                                    >
                                    <label
                                        for="push-email"
                                        class="ml-3"
                                    >
                                        <span class="block text-sm font-medium text-gray-700">Same as email</span>
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input
                                        id="push-nothing"
                                        name="push-notifications"
                                        type="radio"
                                        class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
                                    >
                                    <label
                                        for="push-nothing"
                                        class="ml-3"
                                    >
                                        <span class="block text-sm font-medium text-gray-700">No push notifications</span>
                                    </label>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="py-3 px-4 text-right bg-gray-50 sm:px-6">
                        <button
                            type="submit"
                            class="inline-flex justify-center py-2 px-4 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md border border-transparent focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2 shadow-sm"
                        >
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>