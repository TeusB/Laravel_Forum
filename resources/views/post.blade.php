@extends('layouts.mainLayout')

@section('sidebar')
    @parent
@endsection

@section('content')
    <h1>post</h1>
    post//
    <br>
    title: {{ $data[0]['title'] }}
    <br>
    <br>
    //comments
    <br>
    {{ $data[0]['comments'] }}
    <br>

    <form id="commentForm">
        <label for="title">title</label>
        <input type="text" name="title" required>

        <label for="content">content</label>
        <input type="text" name="content" required>

        <label for="rating">rating</label>
        <input type="number" name="rating" required>

        <button type="submit">comment</button>
    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        const commentForm = document.getElementById("commentForm");
        commentForm.addEventListener('submit', function handleClick(event) {
            event.preventDefault();
            let title = commentForm.elements["title"].value;
            let content = commentForm.elements["content"].value;
            let rating = commentForm.elements["rating"].value;
            sendData(title, content, rating);
        })

        function sendData(title, content, rating) {
            $.ajax({
                method: "POST",
                url: "{{ route('createComment') }}",
                data: {
                    title: title,
                    content: content,
                    rating: rating,
                    idPost: @php echo $_GET['idPost']; @endphp,
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    console.log(data);
                    switch (data["status"]) {
                        case "error":
                            console.log(data["msg"]);
                            break;
                        case "succes":
                            console.log(data["msg"]);
                            break;
                        default:
                            console.log("error json return array unkown key");
                            break;
                    }
                },
                error: function(httpObj, textStatus) {
                    console.log(textStatus);
                    console.log(httpObj);
                    console.log(httpObj.status);
                    switch (httpObj.status) {
                        case 401:
                            console.log("not authorized to do this");
                            break;
                        case 422:
                            let errorObj = httpObj.responseJSON.errors;
                            let firstError = Object.values(errorObj)[0][0];
                            console.log(firstError);
                            console.log("validation error");
                            break;
                        case 0:
                            console.log("no internet connection");
                            break;
                        default:
                            console.log("uncaught case");
                            break;
                    }
                }
            });
        }
    </script>
@endsection
