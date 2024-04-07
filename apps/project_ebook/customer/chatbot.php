<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .chat-container {
            max-width: 500px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .chat-box {
            height: 300px;
            overflow-y: scroll;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .chat-button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: none;
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
        }

        .chat-button:hover {
            background-color: #0056b3;
        }

        /* Chatbot Container */
        #chatbot-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 600px;
        }

        /* Chatbot Toggle Button */
        #chatbot-toggle-button {
            position: fixed;
            bottom: 10px;
            right: 10px;
            cursor: pointer;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
        }

        .message-container {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
            background-color: #f0f0f0;
        }

        .message-text {
            margin: 0;
        }

        .category-button {
            display: inline-block;
            padding: 8px 16px;
            margin: 5px;
            border: 1px solid #007bff;
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .category-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <!-- Chatbot Container -->
    <div id="chatbot-container" style="display: none;">
        <div class="chat-container">
            <div class="chat-box" id="chat-box"></div>
            <input type="button" class="chat-button" value="หนังสือแนะนำประจำเดือน" data-question="หนังสือแนะนำประจำเดือน">
            <input type="button" class="chat-button" value="แนะนำหนังสือตามหมวดหมู่" data-question="แนะนำหนังสือตามหมวดหมู่">
            <input type="button" class="chat-button" value="เกี่ยวกับเว็บไซต์ของเรา" data-question="เกี่ยวกับเว็บไซต์ของเรา">
        </div>
    </div>

    <!-- Chatbot Toggle Button -->
    <div id="chatbot-toggle-button" onclick="toggleChatbot()">Chatbot</div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // JavaScript (script.js)
        var chatbotContainer = document.getElementById("chatbot-container");
        var chatbotToggleButton = document.getElementById("chatbot-toggle-button");

        function toggleChatbot() {
            if (chatbotContainer.style.display === "none") {
                chatbotContainer.style.display = "block";
            } else {
                chatbotContainer.style.display = "none";
            }
        }

        $(document).ready(function() {

            // เรียกใช้งานฟังก์ชัน displayMessage เพื่อแสดงข้อความ "สวัสดี" เมื่อเริ่มต้น
            displayMessage("สวัสดี ฉันคือ chatbot ต้องการให้ช่วยอะไรครับ");

            // ปุ่ม "หนังสือ" และ "ปุ่มหมวดหมู่หนังสือ" จะถูกแสดงเมื่อกดปุ่ม "หนังสือ"
            $(document).on("click", ".chat-button", function() {
                var question = $(this).data("question");
                if (question === "แนะนำหนังสือตามหมวดหมู่") {
                    $.ajax({
                        type: "POST",
                        url: "http://45.136.238.139:3000/v1/ask",
                        contentType: "application/json",
                        data: JSON.stringify({
                            question: question
                        }),
                        success: function(response) {
                            console.log(response);
                            displayCategories(response.answer);
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                } else {
                    sendQuestion(question);
                }
            });

            // ปุ่ม "หมวดหมู่หนังสือ" จะถูกแสดงเมื่อผู้ใช้เลือกหมวดหมู่ที่ต้องการ
            $(document).on("click", ".category-button", function() {
                var category = $(this).data("category");
                sendQuestion(category);
            });

            function sendQuestion(question) {
                $.ajax({
                    type: "POST",
                    url: "http://45.136.238.139:3000/v1/ask",
                    contentType: "application/json",
                    data: JSON.stringify({
                        question: question
                    }),
                    success: function(response) {
                        console.log(response);
                        displayMessage(response.answer);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            function displayMessage(message) {
                if (typeof message === 'object' && message !== null) {
                    var bookList = "<ul>";
                    message.forEach(function(book) {
                        bookList += "<div class='message-container'>";
                        bookList += "<p class='message-text'>" + "ถ้างั้นขอแนะนำเป็นเรื่อง " + book.book_name + "</p>";
                        bookList += '<a href="search_content.php?bookid=' + book.book_id + '">';
                        bookList += '<img src="' + book.book_cover + '" alt="' + book.book_name + '"width="200px" height="200px">';
                        bookList += '</a>';
                        bookList += "<p class='message-text'>" + "เรื่องย่อ" + "</p>";
                        bookList += "<p class='message-text'>" + book.book_summary + "</p>";
                        bookList += '<p class="text-danger message-text">ราคา ' + book.book_price + ' <i class="fas fa-coins"></i></p>';
                        bookList += "</div>";
                    });
                    bookList += "</ul>";
                    $("#chat-box").append(bookList);
                } else {
                    $("#chat-box").append("<div class='message-container'><p class='message-text'>" + message + "</p></div>");
                }
            }

            function displayCategories(categories) {
                var categoryButtons = "";
                categories.forEach(function(category) {
                    categoryButtons += '<input type="button" class="category-button" value="' + category.type_name + '" data-category="' + category.type_name + '">';
                });
                $("#chat-box").html("<p>กรุณาเลือกหมวดหมู่หนังสือ:</p>" + categoryButtons);
            }
        });
    </script>
</body>

</html>
