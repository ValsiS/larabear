<?php declare(strict_types=1); ?>
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Secret UI">
    <meta name="referrer" content="no-referrer"/>
    <title>Larabear UI</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script src="https://www.unpkg.com/larabear"></script>
    <style>
        html {
            box-sizing: border-box;
        }

        *, *:before, *:after {
            box-sizing: inherit;
        }

        body {
            font-family: system-ui, sans-serif;
        }

        .sidebar-active {
            background-color: rgb(17 24 39) !important;
            color: rgb(220 220 220) !important;
            font-weight: 500 !important;
        }
    </style>
</head>
<body class="h-screen w-screen max-h-screen bg-gray-100" hx-target="#primary">
<div style="display: grid; grid-template-columns: 16rem auto;" class="h-full">
    <div class="flex md:w-64 flex-col shadow bg-gray-800">
        <div class="flex flex-col flex-grow pt-2 overflow-y-auto">
            <div class="flex-grow flex flex-col">
                <nav class="flex-1 px-2 pb-4">
                    <x-bear::sidebar.link path="/bear" icon="home">Dashboard</x-bear::sidebar.link>
                    <x-bear::sidebar.divider color="gray-800">Access</x-bear::sidebar.divider>
                    <x-bear::sidebar.link path="/bear/access/token/app" icon="key">API Tokens</x-bear::sidebar.link>
                    <x-bear::sidebar.link path="/bear/access/permission" icon="lock-closed">Permissions</x-bear::sidebar.link>
                    <x-bear::sidebar.link path="/bear/access/role" icon="clipboard-document">Roles</x-bear::sidebar.link>
                    <x-bear::sidebar.link path="/bear/access/user" icon="users">User</x-bear::sidebar.link>
                    <x-bear::sidebar.divider color="gray-800">Config</x-bear::sidebar.divider>
                    <x-bear::sidebar.link path="/bear/config" icon="wrench">Config</x-bear::sidebar.link>
                    <x-bear::sidebar.divider color="gray-800">Credentials</x-bear::sidebar.divider>
                    <x-bear::sidebar.link path="/bear/credential/oauth2/client" icon="rectangle-group">Oauth2 Clients</x-bear::sidebar.link>
                    <x-bear::sidebar.link path="/bear/credential/external" icon="rectangle-group">External Api's</x-bear::sidebar.link>
                    <x-bear::sidebar.divider color="gray-800">Logs</x-bear::sidebar.divider>
                    <x-bear::sidebar.link path="/bear/log/database-change" icon="circle-stack">Database Changes</x-bear::sidebar.link>
                    <x-bear::sidebar.link path="/bear/log/error" icon="exclamation-triangle">Errors</x-bear::sidebar.link>
                    <x-bear::sidebar.link path="/bear/log/response-error" icon="shield-exclamation">Response Errors</x-bear::sidebar.link>
                    <x-bear::sidebar.link path="/bear/log/console" icon="command-line">Console</x-bear::sidebar.link>
                </nav>
            </div>
        </div>
    </div>
    <div id="primary" class="max-w-full min-w-full px-2 md:px-4 pt-2">{!! $content !!}</div>
</div>
</body>
</html>
