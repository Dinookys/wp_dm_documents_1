export default () => ({
    items: [],
    empty: JSON.stringify(window.dm_documents.empty.category),
    item: {...window.dm_documents.empty.category},
    no_items: false,
    current_page: 1,
    total_pages: 1,
    messages: {},
    validationsErrors: {},
    status: {...window.dm_documents.status},    
    categories: [...window.dm_documents.categories],    
    datePickerConf: {
        format: 'DD/MM/YYYY'
    },
    saving: true,
});