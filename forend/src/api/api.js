import axios from 'axios';

let base = 'http://localhost:80';
axios.defaults.baseURL = base;

export const requestLogin = params => {
    // return axios.post(`${base}/login`, params).then(res => res.data);
    return new Promise(function (resolve, reject) {
        resolve({
            msg: '登录成功',
            code: 200,
            user: {
                id: 1,
                username: 'admin',
                password: '123456',
                avatar: 'static/logo.jpg',
                name: 'magician'
            }
        });
    })
};

export const getMagicVideoList = params => {
    return axios.post(`/video/list.php`, {name: 'getMagicVideoList', data: params});
};

export const addMagicVideoInfo = params => {
    return axios.post(`/video/list.php`, {name: 'addMagicVideoInfo', data: params});
};
export const editMagicVideoInfo = params => {
    return axios.post(`/video/list.php`, {name: 'editMagicVideoInfo', data: params});
};
export const deleteMagicVideoInfo = params => {
    return axios.post(`/video/list.php`, {name: 'deleteMagicVideoInfo', data: params});
};
