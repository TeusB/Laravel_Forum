<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>check</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>


    @vite('resources/css/app.css')
    <style>
        #app {
            height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        ::-webkit-scrollbar {
            width: 12px;
            height: 12px;
        }


        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0);
        }

        ::-webkit-scrollbar-thumb {
            background: #ddd;
            /* visibility: hidden; */
        }

        :hover::-webkit-scrollbar-thumb {
            visibility: visible;
        }

        * {
            color: black;
        }
    </style>
</head>

<body>


    <div id="app">
    </div>

    @vite('resources/js/app.js')
</body>

</html>
