<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Editor</title>

    <!-- TinyMCE CDN -->
    <script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
    <!-- <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script> -->
    <script>
        tinymce.init({
            selector: '#emailBody',
            height: 300,
            plugins: 'lists link image code table',
            toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code'
        });
    </script>
</head>
<body>
    <h1>Email Composer</h1>

    <!-- Email form -->
    <form action="{{ route('send.email') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="subject">Subject</label>
            <input type="text" name="subject" id="subject" required>
        </div>
        <div>
            <label for="emailBody">Email Body</label>
            <textarea id="emailBody" name="emailBody"></textarea>
        </div>
        <div>
            <label for="attachment">Attachment (Optional)</label>
            <input type="file" name="attachment" id="attachment">
        </div>
        <div>
            <button type="submit">Send Email</button>
        </div>
    </form>
</body>
</html>
