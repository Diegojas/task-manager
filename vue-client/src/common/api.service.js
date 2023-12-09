import axios from 'axios';
import apiToken from './token.service'

// Create an Axios instance
const apiClient = axios.create({
  baseURL: `${import.meta.env.VITE_API_BASE_URL}/api`,
  headers: {
    'Content-Type': 'application/json',
  },
});

apiClient.interceptors.request.use(
  (config) => {
    if (apiToken.getToken()) {
      config.headers.Authorization = `Bearer ${apiToken.getToken()}`;
    }

    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

export default apiClient;