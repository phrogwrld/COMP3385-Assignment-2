<style> 
<?php include './400007969/css/style.css'; ?>
</style>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>{{{ $title }}}</title>
</head>

<body>
  <div class="bg-black min-h-screen flex flex-col">
    <div class="fixed flex h-16 w-full text-white p-4 justify-between items-center">
      <a class="flex items-center" href="/dashboard">
        <img class="w-8 h-8" src="./400007969/public/logo.svg" alt="logo_here"> ACompany Research
      </a>
      <form id="logoutForm" action="/logout" method="POST">
        <input type="hidden" name="logout" value="1">
        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Logout</button>
      </form>
    </div>

    <div class="container flex-1 flex flex-col mx-auto max-w-4xl p-5 text-white justify-center items-center">
      <div class="grid grid-cols-1 w-full my-8">
        <div class="flex flex-row justify-between">
          <div class="flex flex-col">
            <p class="font-bold">{{ $data['role']->value }}: </p><span id="researcher">{{ $data['username'] }}</span>
          </div>
          <div class="flex flex-col">
            <p class="font-bold">Email: </p><span id="researcher-email">{{ $data['email'] }}</span>
          </div>
        </div>
      </div>

      <hr class="my-3 w-full border-gray-500 opacity-10">

      <div class="grid grid-cols-1 sm:grid-cols-2 mt-5 w-full gap-10 mx-auto justify-center">
        @foreach($data['options'] as $option => $url)
        <a href="{{ $url }}">
          <div class="flex flex-col rounded-md border border-gray-500 bg-gray-600/50 cursor-pointer p-10">
            {{ $option }}
          </div>
        </a>
        @endforeach
      </div>
    </div>
    <footer class="flex border-t border-gray-500 bg-gray-600/50 justify-center items-center">
      <p class="text-sm text-gray-500 py-2">
        © Copyright 2023 Aaron Harris. All Rights Reserved
      </p>
    </footer>
  </div>
</body>

</html>