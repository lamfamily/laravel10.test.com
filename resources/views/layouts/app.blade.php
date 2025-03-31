<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel 无限级分类</title>
    <!-- 引入 Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .category-tree ul {
            list-style-type: none;
            padding-left: 20px;
        }

        .category-tree>ul {
            padding-left: 0;
        }

        .category-tree li {
            margin: 5px 0;
            padding: 5px;
            border-radius: 3px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f8f9fa;
        }

        .category-tree li:hover {
            background-color: #e9ecef;
        }

        .actions {
            display: flex;
            gap: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <header class="mb-4">
            <h1 class="text-center">Laravel 无限级分类系统</h1>
        </header>

        <main>
            @yield('content')
        </main>

        <footer class="mt-5 text-center text-muted">
            <p>&copy; {{ date('Y') }} Laravel 无限级分类示例</p>
        </footer>
    </div>

    <!-- 引入 Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
