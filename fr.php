<?php
session_start();
if (!$_SESSION['user']) {
    header('Location: /');
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISMA</title>
    <link rel="stylesheet" href="./styles/style.css">
    <style>
        .search-container {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .search-input {
            flex: 1;
            padding: 5px;
            margin-right: 5px;
        }
        .search-button {
            padding: 5px 10px;
            margin-right: 5px;
        }
        .toggle-buttons {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="sidebar">
            <ul class="server-list">
                <li>
                    <img src="https://i.yapx.ru/ROvzX.jpg" alt="Website Logo">
                </li>
                <li data-server-name="TSF" data-channels="😂・мемы, 🚮・мусорка, 🔞・nsfw, 👧・ai-девочка, 🎧・войс, 🚪・подвал, ❓・помощь, 💾・чат, 📑・коды, 📚・проекты, 🧮・гайды">
                    <img src="tsf.webp" alt="Server 1 Avatar">
                </li>
                <li data-server-name="ⵋᗝᒋᙖᗣᖘᙢᙅ" data-channels="Main,Music,Games">
                    <img src="harry.webp" alt="Server 2 Avatar">
                </li>
                <!-- ... другие серверы -->
            </ul>
        </div>

        <div class="friends-list">
            <h2>Друзья</h2>
            <div class="toggle-buttons">
                <button id="search-friends" class="search-button">Поиск друзей</button>
                <button id="friend-requests" class="search-button">Запросы дружбы</button>
            </div>
            <div class="search-container" id="search-container" style="display: none;">
                <input type="text" class="search-input" id="friend-search" placeholder="Введите имя друга...">
                <button id="search-button" class="search-button">Поиск</button>
            </div>
            <h2>Личные сообщения</h2>
            <ul id="friend-list">
                <li data-friend-name="Friend1">
                    <img src="friend1_avatar.jpg" alt="Friend 1 Avatar">
                    <span>Friend1</span>
                </li>
                <li data-friend-name="Friend2">
                    <img src="friend2_avatar.jpg" alt="Friend 2 Avatar">
                    <span>Friend2</span>
                </li>
                <li data-friend-name="Friend3">
                    <img src="friend3_avatar.jpg" alt="Friend 3 Avatar">
                    <span>Friend3</span>
                </li>
                <!-- Добавьте больше друзей по необходимости -->
            </ul>
        </div>

        <div class="chat-container">
            <div id="chat-log"></div>
            <div class="input-container">
                <div contenteditable="true" id="chat-input" placeholder="Enter message..."></div>
                <button id="emoji-btn"><img src="emoje_button.png" alt="Emoji Button" width="30" height="30"></button>
            </div>
            <div class="emoji-picker" id="emoji-list" style="display:none">
                <div class="emodjibar">
                    <!-- Кнопки категорий будут добавлены здесь динамически -->
                </div>
                <div class="main-content">
                    <input type="text" class="search-input" placeholder="Найдите идеальный эмодзи">
                    <div class="emoji-grid">
                        <!-- Эмодзи будут добавлены здесь динамически -->
                    </div>
                </div>
            </div>
        </div>

        <div class="user-list">
            <ul>
                <li>
                    <img src="data:image/jpeg;base64,... " alt="User  Avatar">
                    <span>Niko</span>
                </li>
                <!-- Добавьте больше пользователей здесь -->
            </ul>
        </div>
    </div>

    <script>
        // Обработчик события клика на серверах
        document.querySelectorAll('.server-list li').forEach(item => {
            item.addEventListener('click', event => {
                const serverName = item.getAttribute('data-server-name');
                // Перенаправление на server.php с параметром server
                window.location.href = `servers.php?server=${serverName}`;
            });
        });

        // Обработчик события клика на друзьях
        document.querySelectorAll('#friend-list li').forEach(item => {
            item.addEventListener('click', event => {
                const friendName = item.getAttribute('data-friend-name');
                openChatWithFriend(friendName);
            });
        });

        function openChatWithFriend(friendName) {
            const chatLog = document.getElementById('chat-log');
            chatLog.innerHTML = ''; // Очищаем чат

            // Заголовок чата
            const chatHeader = document.createElement('div');
            chatHeader.className = 'chat-header';
            chatHeader.innerHTML = `
                <img src="path/to/friend_avatar.jpg" alt="${friendName} Avatar">
                <span>${friendName}</span>
            `;
            chatLog.appendChild(chatHeader);

            // Здесь можно добавить логику для загрузки сообщений, если это необходимо
        }

        // Переключение между разделами "Поиск друзей" и "Запросы дружбы"
        document.getElementById('search-friends').addEventListener('click', () => {
            document.getElementById('search-container').style.display = 'flex';
            // Здесь можно добавить логику для отображения списка друзей
        });

        document.getElementById('friend-requests').addEventListener('click', () => {
            document.getElementById('search-container').style.display = 'flex';
            // Здесь можно добавить логику для отображения запросов дружбы
        });

        document.getElementById('search-button').addEventListener('click', () => {
            const searchTerm = document.getElementById('friend-search').value;
            // Здесь можно добавить логику для поиска друзей по имени
            console.log(`Поиск друзей с именем: ${searchTerm}`);
        });

        document.getElementById('chat-input').addEventListener('keypress', function(event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault(); // Предотвращаем переход на новую строку
                sendMessage();
            }
        });

        function sendMessage() {
            const chatInput = document.getElementById('chat-input');
            const userInput = chatInput.innerHTML;

            if (userInput.trim() !== '') {
                const newMessage = createMessage(userInput);
                document.getElementById('chat-log').appendChild(newMessage);

                // Очищаем поле ввода
                chatInput.innerHTML = '';

                // Устанавливаем фокус на поле ввода
                chatInput.focus();

                // Перемещаем курсор в начало
                const range = document.createRange();
                const selection = window.getSelection();
                range.selectNodeContents(chatInput);
                range.collapse(true); // Перемещаем курсор в начало
                selection.removeAllRanges();
                selection.addRange(range);
            }
        }

        function createMessage(text) {
            const messageDiv = document.createElement('div');
            messageDiv.className = 'message';

            const avatarImg = document.createElement('img');
            avatarImg.src = "<?= $_SESSION['user']['avatar'] ?>" // замените на абсолютный путь к аватарке
            avatarImg.alt = 'User  Avatar';
            avatarImg.className = 'avatar';
            messageDiv.appendChild(avatarImg);

            const messageContentDiv = document.createElement('div');
            messageContentDiv.className = 'message-content';

            const messageAuthorSpan = document.createElement('span');
            messageAuthorSpan.className = 'message-author';
            messageAuthorSpan.textContent = '<?= $_SESSION['user']['nickname'] ?>'; // Используйте никнейм из базы данных
            messageContentDiv.appendChild(messageAuthorSpan);

            const messageTextP = document.createElement('p');
            messageTextP.className = 'message-text';
            messageTextP.innerHTML = text; // Use a <p> element instead of <span>
            messageContentDiv.appendChild(messageTextP);

            messageDiv.appendChild(messageContentDiv);

            return messageDiv;
        }

        // СИСТЕМА ЭМОДЗИ
        document.getElementById('emoji-btn').addEventListener('click', toggleEmojiList);

        function toggleEmojiList() {
            const emojiList = document.getElementById('emoji-list');
            emojiList.style.display = emojiList.style.display === 'none' ? 'flex' : 'none'; //
        }

        // Load emojis from server2/emoje folder
        // Загрузка эмодзи
        fetch('get_emojis.php')
            .then(response => response.json())
            .then(data => {
                const emojiGrid = document.querySelector('.emoji-grid');

                // Очистить предыдущие эмодзи
                emojiGrid.innerHTML = '';

                // Создать кнопки категорий
                Object.keys(data).forEach(category => {
                    const categoryButton = document.createElement('button');
                    categoryButton.classList.add('category-button');

                    // Создаем изображение для кнопки категории
                    const categoryImage = document.createElement('img');
                    categoryImage.src = `emoje/${category}/ico.png`; // Путь к изображению категории
                    categoryImage.alt = category; // Альтернативный текст
                    categoryImage.width = 44; // Ширина изображения
                    categoryImage.height = 44; // Высота изображения

                    // Добавляем изображение в кнопку
                    categoryButton.appendChild(categoryImage);

                    categoryButton.addEventListener('click', () => {
                        // Переключить активный класс
                        document.querySelectorAll('.category-button').forEach(btn => btn.classList.remove('active'));
                        categoryButton.classList.add('active');

                        // Показать эмодзи для выбранной категории
                        showEmojis(data[category]);
                    });
                    document.querySelector('.emodjibar').appendChild(categoryButton);
                });

                // Показать эмодзи для первой категории по умолчанию
                if (Object.keys(data).length > 0) {
                    showEmojis(data[Object.keys(data)[0]]);
                }

                function showEmojis(emojis) {
                    emojiGrid.innerHTML = ''; // Очистить текущие эмодзи
                    emojis.forEach(emoji => {
                        const emojiButton = document.createElement('button');
                        emojiButton.classList.add('emoji-button');
                        emojiButton.innerHTML = `<img src="${emoji}" alt="Emoji" width="44" height="44">`; // Добавляем изображение эмодзи
                        emojiButton.addEventListener('click', () => {
                            const chatInput = document.getElementById('chat-input');
                            const emojiHtml = `<img src="${emoji}" alt="Emoji" class="emoji">`;

                            document.execCommand('insertHTML', false, emojiHtml);
                            chatInput.focus();
                        });
                        emojiGrid.appendChild(emojiButton);
                    });
                }
            })
            .catch(error => console.error('Error loading emojis:', error));

    </script>
</body>
</html>
