import Vue from "vue"

Vue.filter('capitalize', function (value) {
    if (!value) return ''
    value = value.toString()
    return value.charAt(0).toUpperCase() + value.slice(1)
});

Vue.filter('uppercase', function (value) {
    if (!value) return ''
    value = value.toString()
    return value.toUpperCase();
});

Vue.filter('slice', function (value, number) {
    if (!value) return ''
    value = value.toString();
    if(number && value.length > number) {
        return value.slice(0, number) + '...'
    }
    return value;
});