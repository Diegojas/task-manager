const STORED_ID_TOKEN_KEY = '__@task_manager_token'

const getToken = () => {
  return window.localStorage.getItem(STORED_ID_TOKEN_KEY)
}

const setToken = (token) => {
  return window.localStorage.setItem(STORED_ID_TOKEN_KEY, token)
}

const destroyToken = () => {
  window.localStorage.removeItem(STORED_ID_TOKEN_KEY)
}

export default {
  getToken,
  setToken,
  destroyToken
}