import axios from 'axios';

let base = 'http://101.132.109.3/fdu-magic/backend/src/';
// let base = 'http://localhost/fdu-magic/backend/src/';
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


export const getMagicEventList = params => {
    return axios.post(`/event/list.php`, {name: 'getMagicEventList', data: params});
};

export const addMagicEventInfo = params => {
    return axios.post(`/event/list.php`, {name: 'addMagicEventInfo', data: params});
};
export const editMagicEventInfo = params => {
    return axios.post(`/event/list.php`, {name: 'editMagicEventInfo', data: params});
};
export const deleteMagicEventInfo = params => {
    return axios.post(`/event/list.php`, {name: 'deleteMagicEventInfo', data: params});
};
