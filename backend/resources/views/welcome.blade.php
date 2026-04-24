<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cooperative System | Recruitment Task</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #4F46E5;
            --primary-hover: #4338CA;
            --bg: #F8FAFC;
            --card-bg: rgba(255, 255, 255, 0.8);
            --text-main: #1E293B;
            --text-muted: #64748B;
            --accent: #10B981;
        }

        @media (prefers-color-scheme: dark) {
            :root {
                --bg: #0F172A;
                --card-bg: rgba(30, 41, 59, 0.7);
                --text-main: #F1F5F9;
                --text-muted: #94A3B8;
            }
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg);
            color: var(--text-main);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Background Decoration */
        .blob {
            position: fixed;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(79, 70, 229, 0.15) 0%, rgba(79, 70, 229, 0) 70%);
            border-radius: 50%;
            z-index: -1;
            filter: blur(50px);
            animation: float 20s infinite alternate;
        }

        @keyframes float {
            0% { transform: translate(-10%, -10%); }
            100% { transform: translate(20%, 20%); }
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 4rem 2rem;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        header {
            text-align: center;
            margin-bottom: 4rem;
            animation: fadeInDown 0.8s ease-out;
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .badge {
            display: inline-flex;
            items-center: center;
            padding: 0.5rem 1rem;
            background: rgba(16, 185, 129, 0.1);
            color: var(--accent);
            border-radius: 99px;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--primary), #9333EA);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .subtitle {
            font-size: 1.25rem;
            color: var(--text-muted);
            max-width: 600px;
            margin: 0 auto;
        }

        /* Cards Grid */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 4rem;
        }

        .card {
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 2rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border-color: var(--primary);
        }

        .card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .card p {
            color: var(--text-muted);
            margin-bottom: 2rem;
            flex-grow: 1;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
            gap: 0.5rem;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            transform: scale(1.02);
        }

        .btn-outline {
            border: 2px solid var(--primary);
            color: var(--primary);
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
        }

        /* Table Section */
        .info-section {
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            border-radius: 24px;
            padding: 2.5rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            animation: fadeInUp 0.8s ease-out 0.2s backwards;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .info-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .info-title {
            font-size: 1.5rem;
            font-weight: 600;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        th {
            text-align: left;
            color: var(--text-muted);
            font-weight: 600;
            padding: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .code-snippet {
            background: rgba(0, 0, 0, 0.05);
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            font-family: monospace;
            font-size: 0.9rem;
        }

        footer {
            margin-top: 4rem;
            text-align: center;
            color: var(--text-muted);
            font-size: 0.875rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            h1 { font-size: 2.5rem; }
            .container { padding: 2rem 1rem; }
        }
    </style>
</head>
<body>
    <div class="blob" style="top: -10%; left: -10%;"></div>
    <div class="blob" style="bottom: -10%; right: -10%; background: radial-gradient(circle, rgba(147, 51, 234, 0.1) 0%, rgba(147, 51, 234, 0) 70%);"></div>

    <div class="container">
        <header>
            <div class="badge">
                <span style="display: inline-block; width: 8px; height: 8px; background: var(--accent); border-radius: 50%; margin-right: 8px; animation: pulse 2s infinite;"></span>
                Backend System Online
            </div>
            <h1>Cooperative Request</h1>
            <p class="subtitle">A high-performance recruitment task submission. Built with Laravel 12, featuring RBAC, Clean Architecture, and Docker.</p>
        </header>

        <div class="grid">

            <!-- Card 1: GitHub -->
            <div class="card">
                <h3>📂 Source Code</h3>
                <p>Explore the clean code structure, service layer pattern, and containerization setup on GitHub.</p>
                <a href="https://github.com/Pimwaree-Sethitom/cooperative-request-system" target="_blank" class="btn btn-outline">
                    View Repository
                </a>
            </div>

            <div class="card">
                <h3>📡 Postman Collection</h3>
                <p>Download this file and <strong>Import</strong> it into Postman to start testing the API immediately. Features automatic token management.</p>
                <a href="{{ asset('postman/cooperative_api.json') }}" 
                   onclick="event.preventDefault(); fetch(this.href).then(t=>t.blob()).then(b=>{const a=document.createElement('a');a.href=URL.createObjectURL(b);a.download='cooperative_api.json';a.click()});"
                   class="btn btn-outline">
                    Download & Import
                </a>
            </div>
        </div>

        <div class="info-section">
            <div class="info-header">
                <div class="info-title">Test Credentials & Roles</div>
                <div style="color: var(--text-muted); font-size: 0.875rem;">Default credentials seeded in production</div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Role</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Capability</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Staff</strong></td>
                        <td><span class="code-snippet">staff@test.com</span></td>
                        <td><span class="code-snippet">staff123</span></td>
                        <td>Review & Approve requests</td>
                    </tr>
                    <tr>
                        <td><strong>Public</strong></td>
                        <td><span class="code-snippet">public@test.com</span></td>
                        <td><span class="code-snippet">public123</span></td>
                        <td>Submit new requests</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <footer>
            <p>&copy; 2026 Submission by <strong>Pimwaree Sethitom</strong></p>
            <p style="margin-top: 0.5rem; opacity: 0.6;">Built for Recruitment Process • Powered by Antigravity</p>
        </footer>
    </div>

    <style>
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.4; }
            100% { opacity: 1; }
        }
    </style>
</body>
</html>
