<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Parking Sessions</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6" x-data="parkingApp()">
    <div class="max-w-5xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Parking Session Log</h1>

        <div class="flex gap-3 mb-4">
            <input x-model="search" type="text" placeholder="Search reg/make/model..." class="border p-2 rounded w-full">
            <select x-model="status" class="border p-2 rounded">
                <option value="">All</option>
                <option value="active">Active</option>
                <option value="completed">Completed</option>
            </select>
            <button @click="fetchSessions()" class="bg-blue-500 text-white px-4 rounded">Apply</button>
        </div>

        <table class="min-w-full bg-white shadow rounded">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-2 text-left">Registration</th>
                    <th class="p-2 text-left">Make/Model</th>
                    <th class="p-2 text-left">Entry</th>
                    <th class="p-2 text-left">Exit</th>
                    <th class="p-2 text-left">Duration</th>
                    <th class="p-2 text-left">Status</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="s in sessions" :key="s.id">
                    <tr class="border-t">
                        <td class="p-2" x-text="s.vehicle.registration_number"></td>
                        <td class="p-2" x-text="s.vehicle.make + ' ' + s.vehicle.model"></td>
                        <td class="p-2" x-text="new Date(s.entry_time).toLocaleString()"></td>
                        <td class="p-2" x-text="s.exit_time ? new Date(s.exit_time).toLocaleString() : '-'"></td>
                        <td class="p-2" x-text="s.duration_minutes ? s.duration_minutes + ' min' : '-'"></td>
                        <td class="p-2" x-text="s.status"></td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>

    <script>
        function parkingApp() {
            return {
                sessions: [],
                search: '',
                status: '',
                fetchSessions() {
                    const params = new URLSearchParams({
                        search: this.search,
                        status: this.status,
                        sort: 'entry_time:desc'
                    });
                    fetch(`/api/sessions?${params.toString()}`)
                        .then(r => r.json())
                        .then(d => this.sessions = d.data);
                },
                init() { this.fetchSessions(); }
            }
        }
    </script>
</body>
</html>
