import bearer from '@websanova/vue-auth/drivers/auth/bearer';
import axios from '@websanova/vue-auth/drivers/http/axios.1.x';
import router from '@websanova/vue-auth/drivers/router/vue-router.2.x';

const config = {
  auth: bearer,
  http: axios,
  router: router,
  tokenDefaultName: 'laravel-jwt-auth',
  tokenStore: ['localStorage'],
  rolesVar: 'roles',

  /**
   *
   * из-за того, что пакет websanova
   * возвращает при получении пользовател data.data
   * необходимо написать над ним переопределение
   *
   * */
  parseUserData (data) {
    return data || {}
  },

  authRedirect: `/admin/login`,

  /** API Auth Methods **/
  registerData: {
    url: `/auth/register`,
    method: 'POST',
    redirect: 'admin/login'
  },

  loginData: {
    url: `/admin/auth/login`,
    method: 'POST',
    redirect: '/admin/categories',
    fetchUser: false
  },

  logoutData: {
    url: `/admin/auth/logout`,
    method: 'POST',
    redirect: '/dashboard',
    makeRequest: true
  },

  fetchData: {
    url: `/admin/auth/user`,
    method: 'GET',
    enabled: false
  },

  refreshData: {
    url: `/admin/auth/refresh`,
    method: 'GET',
    enabled: false,
    interval: 30
  }
};

export default config