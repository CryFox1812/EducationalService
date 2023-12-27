new Vue({
    el: '#app',
    data: {
        authenticated: false,
        loginData: {
            username: '',
            password: ''
        }
    },
    methods: {
        login: function() {
            // Реализуйте запрос к вашему API для аутентификации
            fetch('http://your-api-url/api/authenticate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(this.loginData),
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Authentication failed');
                }
                return response.json();
            })
            .then(data => {
                // После успешной аутентификации сохраняем токен в localStorage
                localStorage.setItem('authToken', data.token);

                this.authenticated = true;
            })
            .catch(error => {
                console.error('Authentication error:', error);
            });
        },
        logout: function() {
            // Реализуйте запрос к вашему API для выхода из системы
            fetch('http://your-api-url/api/logout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.getItem('authToken'),
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Logout failed');
                }
                return response.json();
            })
            .then(data => {
                // При выходе из системы удаляем токен из localStorage и 
                localStorage.removeItem('authToken');

                this.authenticated = false;
            })
            .catch(error => {
                console.error('Logout error:', error);
            });
        }
    }
});
