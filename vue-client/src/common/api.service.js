import axios from 'axios';
import apiToken from './token.service'

const isProduction = import.meta.env.MODE === 'production';
const baseUrl = isProduction ? '' : import.meta.env.VITE_API_BASE_URL;
// Create an Axios instance
const apiClient = axios.create({
  baseURL: `${baseUrl}/api`,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
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