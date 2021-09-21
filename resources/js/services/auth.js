import http, { handleError } from '../utils/http';

class Auth {
  login = (email, password) =>
    new Promise((resolve, reject) =>
      http.get('/token/csrf').then(() =>
        http
          .post('/auth/login', { email, password })
          .then((response) => resolve(response.data))
          .catch((error) => reject(handleError(error)))
      )
    );

  logout = () =>
    new Promise((resolve, reject) =>
      http
        .get('/auth/logout')
        .then((response) => resolve(response.data))
        .catch((error) => reject(handleError(error)))
    );
}

const authService = new Auth();

export default authService;
