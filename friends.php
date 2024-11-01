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
    <link rel="stylesheet" href="./styles/frined.css">
</head>

<body>
    <div class="container">
        <div class="sidebar">
            <ul class="server-list">
                <li>
                    <img src="logo.png" alt="Website Logo">
                </li>
                <li data-server-name="TSF" data-channels="😂・мемы, 🚮・мусорка, 🔞・nsfw, 👧・ai-девочка, 🎧・войс, 🚪・подвал, ❓・помощь, 💾・чат, 📑・коды, 📚・проекты, 🧮・гайды">
                    <img src="tsf.webp" alt="Server 1 Avatar">
                </li>
                <li data-server-name="ⵋᗝᒋᙖᗣᖘᙢᙅ" data-channels="Main,Music,Games">
                    <img src="harry.webp" alt="Server 2 Avatar">
                </li>
                <!-- ... other servers -->
            </ul>
        </div>
        <div class="server-info">
            <button id="users-btn">Пользователи</button>
			
            <ul class="friend-list">
                <li>
                    <img src="avatar.png" alt="Друг">
                    <span>Друг</span>
                </li>
                <!-- ... -->
            </ul>
			<div class="theme-container">
				<div class="theme-switcher">
					<span class="theme-option" id="light-theme" style="background-color: white;"></span>
					<span class="theme-option" id="dark-theme" style="background-color: black;"></span>
					<span class="theme-option" id="red-theme" style="background-color: red;"></span>
				</div>
			</div>
        <!-- Добавить поле для ввода сообщения и кнопку отправки -->
        <div class="chat-container">
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
        </div>
    </div>

    <script>
        // -СИСТЕМА ПОИСКА
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
        // КНОПКИ ПОЛЬЗОВАТЕЛЯ 
        const usersBtn = document.getElementById('users-btn');

        usersBtn.addEventListener('click', () => {
                    const chatContainer = document.querySelector('.chat-container');
                    chatContainer.innerHTML = '';

                    const searchSection = document.createElement('div');
                    searchSection.className = 'search-section';
                    chatContainer.appendChild(searchSection);

                    const toggleButtons = document.createElement('div');
                    toggleButtons.className = 'toggle-buttons';
                    searchSection.appendChild(toggleButtons);

                    const findUserBtn = document.createElement('button');
                    findUserBtn.textContent = 'Найти пользователя';
                    findUserBtn.className = 'active';
                    toggleButtons.appendChild(findUserBtn);

                    const requestsBtn = document.createElement('button');
                    requestsBtn.textContent = 'Запросы';
                    toggleButtons.appendChild(requestsBtn);

                    const srContainer = document.createElement('div');
                    srContainer.className = 'sr-container';
                    searchSection.appendChild(srContainer);

                    const searchInput = document.createElement('input');
                    searchInput.type = 'text';
                    searchInput.placeholder = 'Введите имя пользователя';
                    searchInput.id = 'search-input';
                    srContainer.appendChild(searchInput);

                    const searchBtn = document.createElement('button');
                    searchBtn.textContent = '🔎';
                    searchBtn.id = 'search-btn';
                    srContainer.appendChild(searchBtn);

                    const requestsList = document.createElement('ul');
                    requestsList.className = 'requests-list';
                    requestsList.style.display = 'none'; // Initially hidden
                    searchSection.appendChild(requestsList);
                    findUserBtn.addEventListener('click', () => {
                        findUserBtn.classList.add('active');
                        requestsBtn.classList.remove('active');
                        if (srContainer.style.display === 'none') {
                            srContainer.style.display = 'flex'; // Show search input and button
                        } else {
                            // Create srContainer and add search input and button to it
                            const srContainer = document.createElement('div');
                            srContainer.className = 'sr-container';
                            searchSection.appendChild(srContainer);

                            const searchInput = document.createElement('input');
                            searchInput.type = 'text';
                            searchInput.placeholder = 'Введите имя пользователя';
                            searchInput.id = 'search-input';
                            srContainer.appendChild(searchInput);

                            const searchBtn = document.createElement('button');
                            searchBtn.textContent = '🔎';
                            searchBtn.id = 'search-btn';
                            srContainer.appendChild(searchBtn);
                        }
                        requestsList.style.display = 'none'; // Hide requests list
                    });

			requestsBtn.addEventListener('click', () => {
				requestsBtn.classList.add('active');
				findUserBtn.classList.remove('active');
				srContainer.style.display = 'none'; // Hide search input and button
				requestsList.style.display = 'block'; // Show requests list

				// Отправить запрос на сервер для получения запросов дружбы
				const userId = <?php echo $_SESSION['user']['id']; ?>; // получить идентификатор текущего пользователя
				fetch('vendor/getFriendRequests.php', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded'
					},
					body: `userId=${userId}` // передать идентификатор пользователя
				})
				.then(response => response.json())
				.then(data => {
					// Обновить список запросов дружбы
					requestsList.innerHTML = '';
					data.forEach(request => {
						const requestItem = document.createElement('li');
						const avatarImg = document.createElement('img');
						avatarImg.src = request.avatar;
						avatarImg.alt = request.nickname;
						requestItem.appendChild(avatarImg);

						const nameSpan = document.createElement('span');
						nameSpan.textContent = request.nickname;
						requestItem.appendChild(nameSpan);

						const acceptBtn = document.createElement('button');
						acceptBtn.textContent = 'Принять';
						requestItem.appendChild(acceptBtn);

						const declineBtn = document.createElement('button');
						declineBtn.textContent = 'Отклонить';
						requestItem.appendChild(declineBtn);

						requestsList.appendChild(requestItem);

						// Добавить обработчик события клика на кнопку "Принять"
						acceptBtn.addEventListener('click', () => {
							// Отправить запрос на сервер для принятия запроса дружбы
							fetch('vendor/acceptFriendRequest.php', {
								method: 'POST',
								headers: {
									'Content-Type': 'application/x-www-form-urlencoded'
								},
								body: `requestId=${request.id}&userId=${userId}` // передать идентификатор запроса и пользователя
							})
							.then(response => response.text())
							.then(data => {
								console.log(data);
							});
						});

						// Добавить обработчик события клика на кнопку "Отклонить"
						declineBtn.addEventListener('click', () => {
							// Отправить запрос на сервер для отклонения запроса дружбы
							fetch('vendor/declineFriendRequest.php', {
								method: 'POST',
								headers: {
									'Content-Type': 'application/x-www-form-urlencoded'
								},
								body: `requestId=${request.id}&userId=${userId}` // передать идентификатор запроса и пользователя
							})
							.then(response => response.text())
							.then(data => {
								console.log(data);
							});
						});
					});
				});
			});

                    // Example friend requests
                    const requests = [{
                            name: 'Пользователь1',
                            avatar: 'avatar1.jpg'
                        },
                        {
                            name: 'Пользователь2',
                            avatar: 'avatar2.jpg'
                        }
                    ];

                    requests.forEach(request => {
                        const requestItem = document.createElement('li');
                        const avatarImg = document.createElement('img');
                        avatarImg.src = request.avatar;
                        avatarImg.alt = request.name;
                        requestItem.appendChild(avatarImg);

                        const nameSpan = document.createElement('span');
                        nameSpan.textContent = request.name;
                        requestItem.appendChild(nameSpan);

                        const acceptBtn = document.createElement('button');
                        acceptBtn.textContent = 'Принять';
                        requestItem.appendChild(acceptBtn);

                        const declineBtn = document.createElement('button');
                        declineBtn.textContent = 'Отклонить';
                        requestItem.appendChild(declineBtn);

                        requestsList.appendChild(requestItem);

                        searchBtn.addEventListener('click', () => {
                            // Получить значение инпута для поиска пользователя
                            const searchValue = document.getElementById('search-input').value;

                            // Отправить запрос на сервер для поиска пользователя
                            fetch('vendor/searchUser.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded'
                                    },
                                    body: `nickname=${searchValue}`
                                })
                                .then(response => response.json())
                                .then(data => {
                                    // Обновить список пользователей
									// Обновить список пользователей
									let searchResults = document.querySelector('.search-results');
									if (searchResults) {
										searchResults.innerHTML = '';
									} else {
										searchResults = document.createElement('div');
										searchResults.className = 'search-results';
										srContainer.appendChild(searchResults);
									}

                                    data.forEach(user => {
                                        const userDiv = document.createElement('div');
                                        userDiv.className = 'user';

                                        const userAvatar = document.createElement('img');
                                        userAvatar.src = user.avatar;
                                        userAvatar.alt = user.nickname;

                                        const userNickname = document.createElement('span');
                                        userNickname.textContent = user.nickname;

                                        const sendRequestBtn = document.createElement('button');
                                        sendRequestBtn.textContent = 'Отправить запрос дружбы';

                                        userDiv.appendChild(userAvatar);
                                        userDiv.appendChild(userNickname);
                                        userDiv.appendChild(sendRequestBtn);

                                        searchResults.appendChild(userDiv);

                                        // Добавить обработчик события клика на кнопку "Отправить запрос дружбы"
										// Добавить обработчик события клика на кнопку "Отправить запрос дружбы"
										// Добавить обработчик события клика на кнопку "Отправить запрос дружбы"
										// Добавить обработчик события клика на кнопку "Отправить запрос дружбы"
										sendRequestBtn.addEventListener('click', () => {
											// Отправить запрос на сервер для отправки запроса дружбы
											const friendId = user.id; // получить идентификатор друга из результата поиска
											const userId = <?php echo $_SESSION['user']['id']; ?>; // получить идентификатор текущего пользователя
											fetch('vendor/sendRequest.php', {
												method: 'POST',
												headers: {
													'Content-Type': 'application/x-www-form-urlencoded'
												},
												body: `userId=${userId}&friendId=${friendId}&status=pending` // передать идентификатор друга в поле friendId
											})
											.then(response => response.text())
											.then(data => {
												console.log(data);
											});
										});
                                    });
                                });
							});
                        }); // Добавлена закрывающая скобка
                    });
                    //-------------------------
                    document.querySelector('.server-list li img[src="logo.png"]').addEventListener('click', event => {
                        // Перенаправить пользователя на страницу friends.html
                        window.location.href = 'friends.php';
                    });
                    // Получить список друзей
                    const friendList = document.querySelector('.friend-list');

                    // Добавить обработчик события клика на каждый элемент в списке друзей
                    friendList.addEventListener('click', event => {
                        // Проверить, что клик был сделан на элементе списка друзей
                        if (event.target.tagName === 'LI') {
                            // Получить контейнер чата
                            const chatContainer = document.querySelector('.chat-container');

                            // Удалить все существующие элементы чата
                            chatContainer.innerHTML = '';

                            // Получить аватарку и ник пользователя с которым общаемся
                            const avatar = event.target.querySelector('img').src;
                            const nickname = event.target.querySelector('span').textContent;
                            const friendListItem = event.target.closest('li');
                            friendListItem.classList.add('active');
                            // Создать элементы чата
                            const chatLog = document.createElement('div');
                            chatLog.id = 'chat-log';

                            const chatHeader = document.createElement('div');
                            chatHeader.className = 'chat-header';

                            const avatarImg = document.createElement('img');
                            avatarImg.src = avatar;
                            avatarImg.alt = nickname;

                            const nicknameSpan = document.createElement('span');
                            nicknameSpan.textContent = nickname;

                            const inputContainer = document.createElement('div');
                            inputContainer.className = 'input-container';

                            const chatInput = document.createElement('div');
                            chatInput.id = 'chat-input';
                            chatInput.contentEditable = 'true';
                            chatInput.placeholder = 'Enter message...';

                            const emojiBtn = document.createElement('button');
                            emojiBtn.id = 'emoji-btn';
                            emojiBtn.textContent = '😊';

                            const emojiList = document.createElement('div');
                            emojiList.id = 'emoji-list';
                            emojiList.style.display = 'none';

                            // Добавить элементы чата в контейнер чата
                            chatContainer.appendChild(chatLog);
                            chatContainer.appendChild(chatHeader);
                            chatHeader.appendChild(avatarImg);
                            chatHeader.appendChild(nicknameSpan);
                            chatContainer.appendChild(inputContainer);
                            inputContainer.appendChild(chatInput);
                            inputContainer.appendChild(emojiBtn);
                            chatContainer.appendChild(emojiList);

                            // Добавить обработчик события отправки сообщения
                            document.getElementById('chat-input').addEventListener('keypress', function(event) {
                                if (event.key === 'Enter') {
                                    sendMessage();
                                }
                            });

                            function sendMessage() {
                                const userInput = document.getElementById('chat-input').innerHTML;
                                if (userInput.trim() !== '') {
                                    const userAvatar = 'https://masterpiecer-images.s3.yandex.net/d81d5a6166bf11ee99c2baea8797b5f2:upscaled'; // замените на абсолютный путь к аватарке
                                    const userName = 'delete'; // измените на "Вы" или на ник пользователя
                                    const newMessage = createMessage(userInput, userAvatar, userName);
                                    document.getElementById('chat-log').appendChild(newMessage);
                                    document.getElementById('chat-input').innerHTML = '';
                                }
                            }

                            function createMessage(text, userAvatar, userName) {
                                const messageDiv = document.createElement('div');
                                messageDiv.className = 'message';

                                const avatarImg = document.createElement('img');
                                avatarImg.src = userAvatar;
                                avatarImg.alt = userName;
                                messageDiv.appendChild(avatarImg);

                                const messageContentDiv = document.createElement('div');
                                messageContentDiv.className = 'message-content';

                                const messageAuthorSpan = document.createElement('span');
                                messageAuthorSpan.className = 'message-author';
                                messageAuthorSpan.textContent = userName;
                                messageContentDiv.appendChild(messageAuthorSpan);

                                const messageTextP = document.createElement('p');
                                messageTextP.className = 'message-text';
                                messageTextP.innerHTML = text; // Use a <p> element instead of <span>
                                messageContentDiv.appendChild(messageTextP);

                                messageDiv.appendChild(messageContentDiv);

                                return messageDiv;
                            }

                            // Добавить систему эмодзи
                            document.getElementById('emoji-btn').addEventListener('click', toggleEmojiList);

                            function toggleEmojiList() {
                                const emojiList = document.getElementById('emoji-list');
                                emojiList.style.display = emojiList.style.display === 'none' ? 'block' : 'none';
                            }


                        }
                    });

                    // ОТПРАВКА НА СЕРВЕР
                    document.querySelectorAll('.server-list li').forEach(item => {
                        item.addEventListener('click', event => {
                            const serverName = item.getAttribute('data-server-name');
                            const channels = item.getAttribute('data-channels').split(',');

                            // Перенаправить пользователя на страницу index.html
                            window.location.href = 'servers.php?server=' + serverName + '&channels=' + channels.join(',');

                            // Удалить класс .selected-server у всех элементов
                            document.querySelectorAll('.server-list li').forEach(li => {
                                li.classList.remove('selected-server');
                            });

                            // Добавить класс .selected-server к текущему элементу
                            item.classList.add('selected-server');
                        });
                    });
    </script>
</body>

</html>