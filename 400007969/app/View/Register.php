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
      <a class="flex items-center" href="/">
        <img class="w-8 h-8" src="./400007969/public/logo.svg" alt="logo_here"> ACompany Research
      </a>
      <form id="loginForm" action="/login" method="GET">
        <input type="hidden" name="login" value="1">
        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Login</button>
      </form>
    </div>

    <div class="container flex flex-1 mx-auto p-5 text-white justify-center items-center">
      <div class="flex-1 flex flex-row flex-wrap -mx-4 justify-center items-center box-border">
        <div class="flex relative min-w-[600px]">
          <div class="flex relative rounded-lg bg-slate-500 p-10 w-full basis-full">
            <form method="POST" action="/register" class="flex flex-col mx-auto w-[422px]">
              <div class="flex flex-auto mb-7 justify-end">
                <label class="flex pr-2 min-w-[95px] font-semibold items-center">Email: </label>
                <div class="flex flex-col w-full relative">
                  <input class="flex-1 h-10 py-2 px-3 rounded-lg text-black w-full border border-blue-100 focus:border-blue-200 focus:ring focus:outline-none" name="email" />
                </div>
              </div>

              <div class="flex flex-auto mb-7 justify-end">
                <label class="flex pr-2 min-w-[95px] font-semibold items-center">Username: </label>
                <div class="flex flex-col w-full relative">
                  <input class="flex-1 h-10 py-2 px-3 rounded-lg text-black w-full border border-blue-100 focus:border-blue-200 focus:ring focus:outline-none" name="username" />
                </div>
              </div>

              <div class="flex flex-auto mb-7 justify-end">
                <label class="flex pr-2 min-w-[95px] font-semibold items-center">Password: </label>
                <div class="flex flex-col w-full relative">
                  <input class="flex-1 h-10 py-2 px-3 rounded-lg text-black w-full border border-blue-100 focus:border-blue-200 focus:ring focus:outline-none" name="password" />
                  <span class="text-red-500">
                    @if(!empty($data['errors']))
                      @foreach($data['errors'] as $error)
                        {{ $error }}<br>
                      @endforeach
                    @endif
                  </span>
                </div>
              </div>


              <div class="flex justify-between">
                <button name="register" type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg" value="Submit">
                  Submit
                </button>
                <p class="text-blue-300 underline"><a href="/login">Need to login?</a></p>
              </div>
            </form>
          </div>
        </div>
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