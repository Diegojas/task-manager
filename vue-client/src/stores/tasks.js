import { defineStore } from 'pinia';
import apiClient from '../common/api.service';

export const useTaskStore = defineStore('task', {
  state: () => ({
    tasks: []
  }),

  getters: {},

  actions: {
    fetchTaskStats() {
      return new Promise((resolve, reject) => {
        apiClient.get('/stats')
          .then((response) => {
            resolve(response.data.tasks);
          })
          .catch((error) => {
            reject(error);
          })
      });
    },
    fetchTasks() {
      return new Promise((resolve, reject) => {
        apiClient.get('/tasks')
          .then((response) => {
            this.tasks = response.data.data;
            resolve();
          })
          .catch((error) => {
            reject(error);
          })
      });
    },

    createTask(task) {
      return new Promise((resolve, reject) => {
        apiClient.post('/tasks', task)
          .then((response) => {
            this.tasks.push(response.data.data);
            resolve();
          })
          .catch((error) => {
            reject(error);
          })
      });
    },

    async updateTask(task) {
      return new Promise((resolve, reject) => {
        apiClient.put(`/tasks/${task.id}`, task)
          .then((response) => {
            const index = this.tasks.findIndex((t) => t.id === task.id);
            if (index !== -1) {
              this.tasks[index] = response.data.data;
            }
            resolve();
          })
          .catch((error) => {
            reject(error);
          })
      });
    },

    deleteTask(taskId) {
      return new Promise((resolve, reject) => {
        apiClient.delete(`/tasks/${taskId}`)
          .then(() => {
            this.tasks = this.tasks.filter((task) => task.id !== taskId);
            resolve();
          })
          .catch((error) => {
            reject(error);
          })
      });
    }
  }
});