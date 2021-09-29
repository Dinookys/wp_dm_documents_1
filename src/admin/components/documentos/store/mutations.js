export default {
    setMessages(state, payload) {
        state.messages = {
            ...payload
        };
    },
    setValidationsErrors(state, payload) {
        state.validationsErrors = {
            ...payload
        };
    },
    setItems(state, payload) {
        state.items = [...payload];
    },
    setItem(state, payload) {
        state.item = {
            ...payload
        }
    },
    setCurrentPage(state, payload) {
        state.current_page = payload;
    },
    setTotalPages(state, payload) {
        state.total_pages = payload;
    },
    setNoItems(state, payload) {
        state.no_items = payload
    },
    setCategories(state, payload) {
        state.categories = [...payload]
    },
    setSaving(state, payload) {
        state.saving = payload
    }
}