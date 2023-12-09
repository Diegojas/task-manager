import { defineStore } from 'pinia';

export const useNotificationStore = defineStore({
  id: 'notification',
  state: () => ({
    show: false,
    message: '',
    type: 'success'
  }),
  actions: {
    notify({ message, type = 'success' }) {
      this.show = true;
      this.message = message;
      this.type = type;

      setTimeout(() => {
        this.show = false;
      }, 3000);
    },
  },
});