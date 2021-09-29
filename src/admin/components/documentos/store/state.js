export default () => ({
    items: [],
    empty: JSON.stringify(window.dm_documents.empty.document),
    item: {...window.dm_documents.empty.document},
    no_items: false,
    current_page: 1,
    total_pages: 1,
    messages: {},
    validationsErrors: {},
    categories: [...window.dm_documents.categories],
    status: {...window.dm_documents.status},
    datePickerConf: {
        format: 'DD/MM/YYYY'
    },
    saving: true
});