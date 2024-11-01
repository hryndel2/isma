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
                <!-- ... other servers -->
				
            </ul>
			                <li id="create-server-btn" style="text-align: center; margin-top: 10px;">
                    <button style="font-size: 24px; font-weight: bold;">+</button>
                </li>
        </div>
		<div class="server-info">
			<h2 id="server-name"></h2>
			<ul id="channel-list"></ul>
			<div class="theme-container">
				<div class="theme-switcher">
					<span class="theme-option" id="light-theme" style="background-color: white;"></span>
					<span class="theme-option" id="dark-theme" style="background-color: black;"></span>
					<span class="theme-option" id="red-theme" style="background-color: red;"></span>
				</div>
			</div>
		</div>
        <div class="chat-container">
            <div id="chat-log">
            </div>
			<div class="input-container">
				<div contenteditable="true" id="chat-input" placeholder="Enter message..."></div>
				<button id="emoji-btn"><img src="emoje_button.png" alt="Emoji Button" width="30" height="30"></button>
				<button id="file-btn"><img src="file_upload_icon.png" alt="File Upload" width="30" height="30"></button> <!-- Новая кнопка для загрузки файлов -->
			</div>
			<div id="file-preview" style="display: none;"></div> <!-- Для отображения выбранного файла -->
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
                    <img src="data:image/jpeg;base64,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" alt="User   1 Avatar">
                    <span>Niko</span>
                </li>
                <!-- Add more users here -->
            </ul>
        </div>
    </div>
    <div id="create-server-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 1000;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; border-radius: 10px;">
            <h2>Создать сервер</h2>
            <form id="create-server-form">
                <label for="server-name">Название сервера:</label>
                <input type="text" id="server-name" name="name" required>
                <label for="server-avatar">Аватарка сервера:</label>
                <input type="file" id="server-avatar" name="avatar" required>
                <button type="submit">Создать</button>
            </form>
        </div>
    <script>
document.querySelectorAll('.theme-option').forEach(item => {
    item.addEventListener('click', event => {
        const theme = event.target.id;

        // Удаляем все существующие классы темы
        document.body.classList.remove('light-theme', 'dark-theme', 'red-theme');

        // Добавляем выбранный класс темы
        if (theme === 'light-theme') {
            document.body.classList.add('light-theme');
        } else if (theme === 'dark-theme') {
            document.body.classList.add('dark-theme');
        } else if (theme === 'red-theme') {
            document.body.classList.add('red-theme');
        }
    });
});

document.querySelector('.server-list li img[src="https://i.yapx.ru/ROvzX.jpg"]').addEventListener('click', event => {
    // Перенаправить пользователя на страницу friends.html
    window.location.href = 'friends.php';
});

// Делегирование событий для серверов
document.querySelector('.server-list').addEventListener('click', event => {
    if (event.target.tagName === 'IMG') {
        const item = event.target.parentElement;
        const serverName = item.getAttribute('data-server-name');
        const channels = item.getAttribute('data-channels').split(',');

        document.getElementById('server-name').textContent = serverName;

        const channelList = document.getElementById('channel-list');
        channelList.innerHTML = '';

        channels.forEach(channel => {
            const li = document.createElement('li');
            li.textContent = channel.trim();
            li.addEventListener('click', () => {
                document.querySelectorAll('#channel-list li').forEach(li => {
                    li.classList.remove('active');
                });
                li.classList.add('active');
                loadMessages(serverName, channel.trim());
            });
            channelList.appendChild(li);
        });

        document.querySelectorAll('.server-list li').forEach(li => {
            li.classList.remove('selected-server');
        });

        item.classList.add('selected-server');
    }
});

// отправка сообщения
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
        const serverName = document.getElementById('server-name').textContent;
        const activeChannel = document.querySelector('#channel-list .active').textContent;

        fetch('vendor/send_message.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `server_id=${encodeURIComponent(serverName)}&channel_id=${encodeURIComponent(activeChannel)}&content=${encodeURIComponent(userInput)}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
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

                // Обновляем сообщения
                loadMessages(serverName, activeChannel);
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error sending message:', error);
            alert('Failed to send message. Please try again.');
        });
    }
}

function createMessage(text) {
    const messageDiv = document.createElement('div');
    messageDiv.className = 'message';

    const avatarImg = document.createElement('img');
    avatarImg.src = "<?= $_SESSION['user']['avatar'] ?>"; // замените на абсолютный путь к аватарке
    avatarImg.alt = 'User Avatar';
    avatarImg.className = 'avatar';
    messageDiv.appendChild(avatarImg);

    avatarImg.addEventListener('click', event => {
        // Удалить все существующие элементы с информацией о пользователе
        const userInfoElements = document.querySelectorAll('.user-info');
        userInfoElements.forEach(userInfoElement => {
            userInfoElement.remove();
        });

        const avatarSrc = avatarImg.src;
        const userInfo = `
            <div class="container">
                <div class="header">
                    <div class="profile-info">
                        <div class="profile-image" style="background-image: url(${avatarSrc})"></div>
                        <div class="name"><?= $_SESSION['user']['nickname'] ?></div>
                        <div class="username">@<?= $_SESSION['user']['nickname'] ?></div>
                        <div class="bio">Это информация о пользователе</div>
                    </div>
                </div>
            </div>
        `;
        const userInfoElement = document.createElement('div');
        userInfoElement.innerHTML = userInfo;
        userInfoElement.classList.add('user-info');
        document.body.appendChild(userInfoElement);
    });

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
    emojiList.style.display = emojiList.style.display === 'none' ? 'flex' : 'none';
}

// Load emojis from server2/emoje folder
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

// Обработчик события клика на изображениях пользователей
document.querySelectorAll('.message img').forEach(img => {
    img.addEventListener('click', event => {
        // Удалить все существующие элементы с информацией о пользователе
        const userInfoElements = document.querySelectorAll('.user-info');
        userInfoElements.forEach(userInfoElement => {
            userInfoElement.remove();
        });

        // Создание нового элемента с информацией о пользователе
        const userInfo = `
            <div class="container">
                <div class="header">
                    <div class="profile-info">
                        <div class="profile-image" style="background-image: url(${img.src})"></div>
                        <div class="name">delete</div>
                        <div class="username">@delete</div>
                        <div class="bio">Это информация о пользователе</div>
                    </div>
                </div>
            </div>
        `;
        const userInfoElement = document.createElement('div');
        userInfoElement.innerHTML = userInfo;
        userInfoElement.classList.add('user-info');
        document.body.appendChild(userInfoElement);
    });
});

document.addEventListener('click', function(event) {
    const userInfoElements = document.querySelectorAll('.user-info');
    if (userInfoElements.length > 0) {
        const userInfoElement = userInfoElements[0];
        if (!userInfoElement.contains(event.target) && event.target !== userInfoElement) {
            if (userInfoElement.dataset.created) {
                userInfoElement.remove();
            } else {
                userInfoElement.dataset.created = 'true';
            }
        }
    }
});

/* ПОЛУЧЕНИЕ СЕРВЕРА */
// Получить параметры URL
const urlParams = new URLSearchParams(window.location.search);

// Получить имя сервера и список каналов
const serverName = urlParams.get('server');
let channels = [];
if (urlParams.get('channels')) {
    channels = urlParams.get('channels').split(',');
}
// Отобразить информацию о сервере
document.getElementById('server-name').textContent = serverName;

// Создать список каналов
const channelList = document.getElementById('channel-list');
channelList.innerHTML = '';

channels.forEach(channel => {
    const li = document.createElement('li');
    li.textContent = channel;
    li.addEventListener('click', () => {
        document.querySelectorAll('#channel-list li').forEach(li => {
            li.classList.remove('active');
        });
        li.classList.add('active');
        loadMessages(serverName, channel.trim());
    });
    channelList.appendChild(li);
});

// Добавление серверов
document.getElementById('create-server-btn').addEventListener('click', () => {
    document.getElementById('create-server-modal').style.display = 'flex';
});

document.getElementById('create-server-form').addEventListener('submit', async (event) => {
    event.preventDefault();

    const formData = new FormData(event.target);
    const response = await fetch('vendor/create_server.php', {
        method: 'POST',
        body: formData
    });

    if (response.ok) {
        location.reload();
    } else {
        alert('Ошибка при создании сервера');
    }
});

        fetch('vendor/get_user_servers.php')
            .then(response => response.json())
            .then(servers => {
                const serverList = document.querySelector('.server-list');
                servers.forEach(server => {
                    const li = document.createElement('li');
                    li.setAttribute('data-server-name', server.name);
                    li.setAttribute('data-channels', 'game, menu');
                    const img = document.createElement('img');
                    img.src = server.avatar;
                    img.alt = server.name;
                    li.appendChild(img);
                    serverList.appendChild(li);
                });
            })
            .catch(error => console.error('Error loading servers:', error));


    </script>
</body>

</html>
