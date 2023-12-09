import { defineStore } from 'pinia'
import apiClient from '../common/api.service'
import tokenService from '../common/token.service';

export const useUserStore = defineStore('user', {
  state: () => ({
    user: {},
    token: tokenService.getToken(),
    loading: false,
  }),
  getters: {
    isAuthenticated: (state) => !!state.token
  },
  actions: {
    async register(user) {
      try {
        const response = await apiClient.post('/register', user);
        this.token = response.data.token;
        this.user = response.data.user;

        tokenService.setToken(this.token);
      } catch (error) {
        throw error;
      }
    },

    async login(credentials) {
      try {
        const response = await apiClient.post('/login', credentials);
        this.token = response.data.token;
        this.user = response.data.user;

        tokenService.setToken(this.token);
      } catch (error) {
        throw error;
      }
    },

    async getAuthenticatedUser() {
      try {
        const response = await apiClient.get('/auth/me');
        this.user = response.data;
      } catch (error) {
        console.log('Error', error)
      }
    },

    async logout() {
      try {
        await apiClient.post('/logout');
        this.token = null;
        this.user = {};
        tokenService.destroyToken();
      } catch (error) {
        console.log('Error', error)
      }
    }
  }
})