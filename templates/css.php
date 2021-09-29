<style>

.dm-document .cols {
    display: grid;
    width: 100%;
    align-items: center;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
}

.dm-document .flex-align-top {
    align-items: start;
}

.dm-document .cols-100 {
    grid-template-columns: 100%;
}

.dm-document .cols-25-50-25 {
    grid-template-columns: 25% 50% 25%;
}

.dm-document .cols-25-75 {
    grid-template-columns: 25% 75%;
}

.dm-document .cols-65-35 {
    grid-template-columns: 65% 35%;
}

.dm-document .cols-45-10-45 {
    grid-template-columns: 45% 10% 45%;
}

.dm-document .cols-40-40-20 {
    grid-template-columns: 40% 40% 20%;
}

.dm-document .cols-15-85 {
    grid-template-columns: 15% 85%;
}

.dm-document .cols-33 {
    grid-template-columns: repeat(3, 1fr);
}

.dm-document .cols-50 {
    grid-template-columns: repeat(2, 1fr);
}

.dm-document .cols {
    width: 100%;
}

.dm-document .cols input, .dm-document .cols select, .dm-document .cols textarea, .dm-document .cols label {
    width: 100% !important;
}

.dm-document .cols>div {
    padding: 5px;
}

.dm-document .cols .mx-datepicker {
    width: 100%;
}

.dm-document-search {
    background-color: #eee;
    border: 1px solid #ccc;
}

.dm-document-search button {
    display: block;
    width: 100%;
}

.dm-document-text-right {
    text-align: right;
}

.dm-document-items {
    display: flex;
    gap: 15px;
    margin-top: 20px;
    flex-wrap: wrap;
}

.dm-document-loop-item {
    border: 1px solid #ccc;
    margin-bottom: 10px;
}

.dm-document-loop-item>h3 {
    margin: 0 0 15px 0;
    text-transform: uppercase;
}

.dm-document-items .dm-document-loop-item {
    flex: 0 0 100%;
}

.dm-document-loop-item {
    position: relative;
    display: flex;
    flex-direction: column;
    padding: 0;
}

.dm-document-loop-item>div {
    padding: 10px;
}

.dm-document-loop-item .dm-title,
.dm-document-loop-item .dm-document-loop-item-header {
    border-bottom: 1px solid #ccc;
    /* margin: 0 0 20px 0; */
    padding: 10px;
    background-color: #eee;
}

.dm-document-loop-item .dm-title {
    margin: 0;
}

.dm-document-loop-item .dm-document-loop-item-header .data {
    font-size: .70em;
    position: absolute;
    right: 10px;
    top: 0;
    font-weight: bold;
    color: #686868;
}

.dm-document-loop-item .dm-document-loop-item-footer {
    margin-top: auto;
    text-align: right;
    border-top: 1px solid #ccc;
    padding: 5px 10px;
}

.dm-document-box-document {
    font-size: 12px;
}

.dm-icon svg {
    width: 15px;
}

.dm-document-loop-item a > .dm-icon {
    margin-right: 10px;
}

.dm-document-box-document:not(:last-child) {
    border-bottom: 1px solid #ccc;
}

@media (min-width: 768px) {
    .dm-subcategoria.dm-document-loop-item {
        flex: 0 0 49%;
    }
}
</style>
