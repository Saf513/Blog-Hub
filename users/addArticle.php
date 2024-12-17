<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body>

    <div class="bg-gradient-to-t from-purple-200 via-purple-50 to-purple-50 py-20 px-4 font-[sans-serif]">
        <div class="max-w-4xl w-full mx-auto text-center">
            <h2 class="text-gray-800 text-4xl md:text-5xl font-extrabold mb-6 leading-[45px]">Create your publication</h2>
            <p class="text-base text-gray-600">Stay updated with our latest news and exclusive offers. Join our community today!</p>
            <form class="font-[sans-serif] m-6 max-w-4xl mx-auto mt-4">
                <div class="grid sm:grid-cols-2 gap-10">
                    <div class="relative flex items-center">
                        <label class="text-[13px] bg-white text-black absolute px-2 top-[-10px] left-[18px]">
                            Email</label>
                        <input type="text" placeholder="Enter first name"
                            class="px-4 py-3.5 bg-white text-black w-full text-sm border-2 border-gray-100 focus:border-blue-500 rounded outline-none" />
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-4"
                            viewBox="0 0 24 24">
                            <circle cx="10" cy="7" r="6" data-original="#000000"></circle>
                            <path
                                d="M14 15H6a5 5 0 0 0-5 5 3 3 0 0 0 3 3h12a3 3 0 0 0 3-3 5 5 0 0 0-5-5zm8-4h-2.59l.3-.29a1 1 0 0 0-1.42-1.42l-2 2a1 1 0 0 0 0 1.42l2 2a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42l-.3-.29H22a1 1 0 0 0 0-2z"
                                data-original="#000000"></path>
                        </svg>
                    </div>

                    <div class="relative flex items-center">
                        <label class="text-[13px] bg-white text-black absolute px-2 top-[-10px] left-[18px]">Title
                        </label>
                        <input type="text" placeholder="Enter last name"
                            class="px-4 py-3.5 bg-white text-black w-full text-sm border-2 border-gray-100 focus:border-blue-500 rounded outline-none" />

                    </div>
                    <div class="relative">
                        <!-- Label -->
                        <label for="description" class="text-[13px] text-gray-700 absolute px-2 bg-white top-[-10px] left-4">
                            Description
                        </label>
                        <!-- Textarea -->
                        <textarea id="description" placeholder="Enter your description here..."
                            rows="4"
                            class="w-full px-4 py-3 bg-white text-black border-2 border-gray-300 rounded focus:outline-none focus:border-blue-500 placeholder-gray-400">
                        </textarea>
                    </div>
                </div>
                <div class="font-[sans-serif] max-w-md mx-auto">
      <label class="text-base font-semibold text-gray-600 mb-2 block">Upload files</label>
      <input type="file" class="w-full text-gray-400 font-semibold text-sm bg-white border file:cursor-pointer cursor-pointer file:border-0 file:py-2.5 file:px-4 file:mr-4 file:bg-gray-100 file:hover:bg-gray-200 file:text-gray-600 rounded" />

      <div
        class="mt-5 bg-gray-50 text-gray-600 text-base rounded w-full h-48 flex flex-col items-center justify-center border-2 border-gray-300 border-dashed">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 mb-2 fill-gray-400" viewBox="0 0 32 32">
          <path
            d="M23.75 11.044a7.99 7.99 0 0 0-15.5-.009A8 8 0 0 0 9 27h3a1 1 0 0 0 0-2H9a6 6 0 0 1-.035-12 1.038 1.038 0 0 0 1.1-.854 5.991 5.991 0 0 1 11.862 0A1.08 1.08 0 0 0 23 13a6 6 0 0 1 0 12h-3a1 1 0 0 0 0 2h3a8 8 0 0 0 .75-15.956z"
            data-original="#000000" />
          <path
            d="M20.293 19.707a1 1 0 0 0 1.414-1.414l-5-5a1 1 0 0 0-1.414 0l-5 5a1 1 0 0 0 1.414 1.414L15 16.414V29a1 1 0 0 0 2 0V16.414z"
            data-original="#000000" />
        </svg>
        <p class="text-base font-semibold text-gray-600">Drag & Drop files here</p>
      </div>
    </div>
                <button type="button"
                    class="mt-8 px-6 py-2.5 w-full text-sm bg-blue-500 text-white rounded hover:bg-blue-600 transition-all">Submit</button>
            </form>
        </div>
    </div>

</body>

</html>