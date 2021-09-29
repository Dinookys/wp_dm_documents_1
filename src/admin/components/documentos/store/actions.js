import axios from "axios";

const getItems = async ({commit}, payload) => {

    let params = serializeObj(payload);

    commit('setItems', []);
    commit('setNoItems', false);

    axios.get(`/b/documents/list?${params}` ).then((resp) => {
        try {
            let { items, current_page, total_pages } = resp.data;
            
            if(items.length) {
                commit('setItems', items);
                commit('setNoItems', false);
            } else {
                commit('setNoItems', true);
            }

            commit('setCurrentPage', current_page);
            commit('setTotalPages', total_pages);
        } catch (e) { console.error(e) }
    }).catch(() => {
        commit('setNoItems', true);
    });
};

const getItem = ({commit}, id) => {
    commit('setSaving', true);
    axios.get(`/b/documents/edit?id=${id}`).then(({status, data}) => {
        if(data && status == '200') {

            /*Setando os valores padrões*/
            commit('setItem', {...data});
            commit('setSaving', false);
        }
    });
}

const newEmptyItem = ({commit, state}) => {
    /*Setando os valores padrões*/
    commit('setItem', JSON.parse(state.empty));
    commit('setSaving', false);
}

const saveItem = ({commit, dispatch}, payload) => {

    dispatch('clearMessages');
    commit('setSaving', true);

    axios.post('/b/documents/save', payload).then(({data}) => {
        
        if(data.item && payload.ID) {
            commit('setItem', data.item);
        }

        if(payload.ID == undefined && data.item && "ID" in data.item) {
            dispatch('newEmptyItem');
        }

        if(data.messages) {

            if('validation_errors' in data.messages) {
                commit('setValidationsErrors', data.messages.validation_errors)
            } else {                
                commit('setMessages', data.messages)
            }

        }

        commit('setSaving', false);

    });
}

const removeItem = ({ commit }, payload) => {
    axios.post('/b/documents/delete', payload).then((resp) => {
        try {
            let { items, current_page, total_pages } = resp.data;
            
            commit('setItems', items);

            if(items.length) {
                commit('setNoItems', false);
            } else {                
                commit('setNoItems', true);
            }

            commit('setCurrentPage', current_page);
            commit('setTotalPages', total_pages);
        } catch (e) {
            console.log(e);
        }
    });
}

const updateCategories = ({commit}) => commit('setCategories', window.dm_documents.categories);

const destroyItem = ({commit}) => commit('setItem', {})
const clearMessages = ({commit}) => {
    commit('setMessages', {});
    commit('setValidationsErrors', {});
}

const serializeObj = (obj) => {
    return Object.keys(obj).map(function(key) {
        return key + '=' + encodeURIComponent(obj[key]);
    }).join('&');
}

export default {
    getItem,
    destroyItem,
    getItems,
    saveItem,
    removeItem,
    newEmptyItem,
    clearMessages,
    updateCategories
}