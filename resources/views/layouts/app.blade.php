<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Sistem Akademik Sekolah')
    </title>



    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">


    
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">


    
    
    

    <style>
        * {
            box-sizing: border-box;
        }


        html,
        body {
            margin: 0;
            padding: 0;
        }


        body {

            font-family:
                Arial,
                sans-serif;

            background: #f8fafc;

            color: #1e293b;

        }


        
        
        

        .wrapper {

            display: flex;

            min-height: 100vh;

        }


        
        
        

        .main {

            margin-left: 250px;

            width: calc(100% - 250px);

            min-height: 100vh;

        }


        
        
        

        .navbar {

            height: 65px;

            background: white;

            border-bottom: 1px solid #e2e8f0;

            display: flex;

            align-items: center;

            justify-content: space-between;

            padding: 0 30px;

        }


        .navbar h3 {

            font-size: 18px;

            margin: 0;

            font-weight: 600;

        }


        .admin-info {

            font-size: 14px;

            color: #64748b;

        }


        
        
        

        .content {

            padding: 30px;

        }


        
        
        

        .page-header {

            margin-bottom: 25px;

        }


        .page-header h1 {

            font-size: 24px;

            margin-bottom: 5px;

        }


        .page-header p {

            color: #64748b;

            font-size: 14px;

        }


        
        
        

        .card {

            border-radius: 10px;

        }


        
        
        

        .table-wrapper {

            overflow-x: auto;

        }


        table {

            width: 100%;

            border-collapse: collapse;

        }


        th,
        td {

            padding: 12px 15px;

            border-bottom: 1px solid #e2e8f0;

            text-align: left;

            font-size: 14px;

        }


        th {

            background: #f1f5f9;

            font-weight: 600;

        }


        
        
        

        .btn {

            border-radius: 6px;

        }


        
        
        

        .alert {

            border-radius: 6px;

        }


        
        
        

        

        .kelas-search-card {

            margin-bottom: 40px;

        }


        .kelas-search {

            max-width: 650px;

        }


        .kelas-search .input-group-text {

            background: #eff6ff;

        }


        .kelas-search .form-control {

            height: 44px;

        }


        .kelas-search .form-control:focus {

            border-color: #2449a4;

            box-shadow:
                0 0 0 .2rem rgba(25, 135, 84, .15);

        }


        

        .kelas-grid {

            display: grid;

            grid-template-columns:
                repeat(3, minmax(0, 1fr));

            gap: 24px;

        }


        

        .kelas-item {

            min-width: 0;

        }


        .kelas-link {

            display: block;

            height: 100%;

            text-decoration: none;

        }


        .kelas-card {

            height: 100%;

            border-radius: 12px;

            transition:
                transform .2s ease,
                box-shadow .2s ease;

        }


        .kelas-card:hover {

            transform:
                translateY(-5px);

            box-shadow:
                0 10px 25px rgba(0, 0, 0, .10) !important;

        }


        .kelas-icon {

            transition:
                transform .2s ease;

        }


        .kelas-card:hover .kelas-icon {

            transform:
                scale(1.05);

        }

        .page-header h1 {
            color: #2449a4;
            font-size: 25px;
            font-weight: 600;
        }

        .page-header p {
            color: #64748b;
            font-size: 14px;
        }

        .card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 12px rgba(15, 23, 42, .05);
        }

        .table-wrapper {
            border-radius: 8px;
        }

        table th {
            background: #eff6ff;
            color: #1e3a8a;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .02em;
        }

        table tbody tr:hover td {
            background: #f8fbff;
        }

        .content .btn-primary {
            background: #2449a4;
            border-color: #2449a4;
        }

        .content .btn-primary:hover {
            background: #1d3d8b;
            border-color: #1d3d8b;
        }

        .content .btn-secondary {
            background: #e2e8f0;
            border-color: #cbd5e1;
            color: #334155;
        }

        .content .form-control:focus,
        .content .form-select:focus {
            border-color: #2449a4;
            box-shadow: 0 0 0 .2rem rgba(36, 73, 164, .15);
        }


        

        .kelas-empty {

            grid-column:
                1 / -1;

        }


        

        @media (max-width: 991px) {

            .kelas-grid {

                grid-template-columns:
                    repeat(2, minmax(0, 1fr));

            }

        }


        @media (max-width: 575px) {

            .kelas-grid {

                grid-template-columns:
                    1fr;

            }

        }


        
        
        

        @media (max-width: 768px) {

            .main {

                margin-left: 210px;

                width:
                    calc(100% - 210px);

            }


            .content {

                padding: 20px;

            }


            .navbar {

                padding:
                    0 20px;

            }

        }
    </style>


    
    @stack('styles')

</head>


<body>


    <div class="wrapper">


        
        @php
            $currentUser = auth()->user();
            $currentRole = $currentUser?->role_id;
        @endphp

        @if($currentUser && $currentRole == 5)
            @include('layouts.sidebar-siswa')
        @elseif($currentUser && $currentRole == 3)
            @include('layouts.sidebar-wali-kelas')
        @elseif($currentUser && $currentRole == 2)
            @include('layouts.sidebar-guru')
        @elseif($currentUser && $currentRole == 1)
            @include('layouts.sidebar')
        @elseif(request()->is('siswa') || request()->is('siswa/*'))
            @include('layouts.sidebar-siswa')
        @elseif(request()->is('guru') || request()->is('guru/*'))
            @include('layouts.sidebar-guru')
        @elseif(request()->is('wali-kelas') || request()->is('wali-kelas/*'))
            @include('layouts.sidebar-wali-kelas')
        @else
            @include('layouts.sidebar')
        @endif

   
    <main class="main">


            
            <nav class="navbar">

                <h3>

                    @yield(
                        'title',
                    )

                </h3>


                <div class="admin-info">



                </div>

            </nav>


            
            
            

            <section class="content">


                
                @if(session('success'))

                    <div class="alert alert-success">

                        {{ session('success') }}

                    </div>

                @endif


                
                @if(session('error'))

                    <div class="alert alert-danger">

                        {{ session('error') }}

                    </div>

                @endif

                @yield('content')

            </section>


        </main>


    </div>


    
    
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    
    
    

    @stack('scripts')


    
    
    

    <script>

        document.addEventListener(
            'DOMContentLoaded',
            function () {

                const sidebar =
                    document.querySelector(
                        '.sidebar'
                    );

                if (!sidebar) {
                    return;
                }


                const savedScroll =
                    sessionStorage.getItem(
                        'sidebarScroll'
                    );


                if (
                    savedScroll !== null
                ) {

                    sidebar.scrollTop =
                        parseInt(
                            savedScroll
                        );

                }


                sidebar.addEventListener(
                    'scroll',
                    function () {

                        sessionStorage.setItem(
                            'sidebarScroll',
                            sidebar.scrollTop
                        );

                    }
                );

            }
        );

    </script>


</body>

</html>