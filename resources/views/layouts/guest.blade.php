<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="icon" type="image/png" href="{{ asset('images/l-key.png') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 bg-login">
        <div class="h-screen flex flex-col p-8 justify-center items-center">
            <div class="w-1/3 flex flex-col p-6 shadow-md overflow-hidden rounded-3xl min-h-full items-center justify-center content-center bg-flou bg-flou-filter">
                {{--<div class="mb-8 border-global rounded-full p-8 shadow-[-3px_3px_0px_1px_#FFCA2B]">
                    <a href="/">
                        <x-application-logo />
                    </a>
                </div>--}}
                <a href="#" class="mb-12">
                    <img src="{{ asset('images/l-key.png') }}" width="100">
                </a>
                {{ $slot }}
            </div>
            <svg style="display: none">
                <filter id="filter" color-interpolation-filters="linearRGB" filterUnits="objectBoundingBox" primitiveUnits="userSpaceOnUse">
                    <feDisplacementMap in="SourceGraphic" in2="SourceGraphic" scale="20" xChannelSelector="R" yChannelSelector="B" x="0%" y="0%" width="100%" height="100%" result="displacementMap" />
                    <feGaussianBlur stdDeviation="3 3" x="0%" y="0%" width="100%" height="100%" in="displacementMap" edgeMode="none" result="blur" />
                </filter>
            </svg>
            <svg style="display: none">
                <filter id="lg-dist" x="0%" y="0%" width="100%" height="100%">
                    <feTurbulence type="fractalNoise" baseFrequency="0.008 0.008" numOctaves="2" seed="92" result="noise" />
                    <feGaussianBlur in="noise" stdDeviation="2" result="blurred" />
                    <feDisplacementMap in="SourceGraphic" in2="blurred" scale="70" xChannelSelector="R" yChannelSelector="G" />
                </filter>
            </svg>
        </div>
    </body>
</html>
