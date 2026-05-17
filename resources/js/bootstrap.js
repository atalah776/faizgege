import axios from 'axios';

// Membuat Axios bisa diakses dari mana saja di file JS kamu dengan memanggil 'window.axios'
window.axios = axios;

// Mengatur header agar Laravel tahu bahwa ini adalah request AJAX (XMLHttpRequest)
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
