import { createApp } from 'vue'
import { createPinia } from 'pinia'
import router from './router'
import { useUserStore } from './stores/user'
import './index.css'
import App from './App.vue'

const app = createApp(App)
const pinia = createPinia()

app.use(pinia)
app.use(router)

router.beforeEach((to, from, next) => {
  const user = useUserStore(pinia)

  if (to.meta.requiresAuth && !user.token) {
    next({ name: "Login" });
  } else if (user.token && to.meta.isGuest) {
    next({ name: "Dashboard" });
  } else {
    next();
  }
      
})

app.mount('#app')
