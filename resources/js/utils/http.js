import axios from 'axios';

export const cancelToken = axios.CancelToken.source();

export const http = axios.create({
  baseURL: '/api',
  withCredentials: true,
  cancelToken: cancelToken.token
});

export const handleError = (error) => {
  if (error.response) {
    if (error.response.status === 401) {
      window.location = '/auth/login';
    }

    return error.response;
  } else {
    return error.message;
  }
};

export const paramsToFilter = (object) => {
  return object
    ? Object.entries(object)
        .map(([key, value]) => `filter[${key}]=${value}`)
        .join('&')
    : '';
};

export default http;
