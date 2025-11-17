import CustomUploadPlugin from './custom-upload-image.js';
import {
    ClassicEditor,
    // Cơ bản
    Essentials, Paragraph, Heading,
    // Text styles
    Bold, Italic, Underline, Strikethrough, Subscript, Superscript,
    Code, CodeBlock,
    Font, FontSize, FontFamily, FontColor, FontBackgroundColor,
    Highlight,
    Alignment,
    // Danh sách
    List, TodoList, ListProperties,
    // Liên kết & trích dẫn
    Link, BlockQuote,
    // Hình ảnh
    Image, ImageToolbar, ImageStyle, ImageCaption, ImageUpload, ImageResize, Base64UploadAdapter,
    // Bảng
    Table, TableToolbar, TableProperties, TableCellProperties,
    // Phương tiện
    MediaEmbed,
    // Khác
    HorizontalLine, Indent, IndentBlock,
    RemoveFormat,
    // Widget tiện ích
    Mention, SpecialCharacters, SpecialCharactersEssentials,
    HtmlEmbed, Notification
} from 'ckeditor5';

import 'ckeditor5/ckeditor5.css';

const element = document.querySelector('#editor');

const editor = await ClassicEditor.create(element, {
    licenseKey: 'GPL',

    plugins: [
        Essentials, Paragraph, Heading,
        Bold, Italic, Underline, Strikethrough, Subscript, Superscript,
        Code, CodeBlock,
        Font, FontSize, FontFamily, FontColor, FontBackgroundColor,
        Highlight,
        Alignment,
        List, TodoList, ListProperties,
        Link, BlockQuote,
        Image, ImageToolbar, ImageStyle, ImageCaption, ImageUpload, ImageResize, Base64UploadAdapter,
        Table, TableToolbar, TableProperties, TableCellProperties,
        MediaEmbed,
        HorizontalLine, Indent, IndentBlock,
        RemoveFormat,
        Mention, SpecialCharacters, SpecialCharactersEssentials,
        HtmlEmbed, Notification, CustomUploadPlugin,
    ], extraPlugins: [CustomUploadPlugin],


    toolbar: {
        items: [
            'undo', 'redo',
            '|',
            'heading',
            '|',
            'fontFamily', 'fontSize', 'fontColor', 'fontBackgroundColor',
            '|',
            'bold', 'italic', 'underline',
            '|',
            'bulletedList', 'numberedList', 'todoList',
            '|',
            'alignment', 'outdent', 'indent',
            '|',
            'link', 'blockQuote', 'code', 'codeBlock',
            '|',
            'insertTable', 'imageUpload', 'mediaEmbed', 'horizontalLine', 'htmlEmbed', 'chooseImage',
            '|',
            'strikethrough', 'subscript', 'superscript',
        ],
        shouldNotGroupWhenFull: true,
    },

    image: {
        styles: [
            'alignLeft',
            'alignCenter',
            'alignRight','inline', 'block', 'side'
        ],
        toolbar: [
            'imageStyle:alignLeft',
            'imageStyle:alignCenter',
            'imageStyle:alignRight',
            '|',
            'imageStyle:inline',
            'imageStyle:block',
            'imageStyle:side',
            '|',
            'toggleImageCaption',
            'imageTextAlternative',
            '|',
            'resizeImage'
        ],
        resizeOptions: [
            { name: 'resizeImage:original', label: 'Original', value: null },
            { name: 'resizeImage:50', label: '50%', value: '50' },
            { name: 'resizeImage:75', label: '75%', value: '75' }
        ],
        resizeUnit: '%'
    },

    table: {
        contentToolbar: [
            'tableColumn', 'tableRow', 'mergeTableCells',
            '|',
            'tableProperties', 'tableCellProperties'
        ]
    },

    link: {
        decorators: {
            openInNewTab: {
                mode: 'manual',
                label: 'Open in new tab',
                attributes: { target: '_blank', rel: 'noopener noreferrer' }
            }
        }
    },

    list: {
        properties: {
            styles: true,
            startIndex: true,
            reversed: true
        }
    },

    mention: {
        feeds: [
            {
                marker: '@',
                feed: ['@MaiHuy', '@Admin', '@Reviewer', '@Manager'],
                minimumCharacters: 1
            }
        ]
    },

    mediaEmbed: {
        previewsInData: true
    },

    htmlEmbed: {
        showPreviews: true
    }
}).then(editor => {
    window.editor = editor;
    const updateButton = document.querySelector('#update');
    const saveButton = document.querySelector('#save');
    const notification = editor.plugins.get('Notification');
    const feedback = document.querySelector('#editor-feedback');
    if (updateButton) {
        updateButton.addEventListener('click', () => {
            const data = editor.getData();
            Livewire.dispatch('update-content', { value: data });
        });
    }
    if (saveButton) {
        saveButton.addEventListener('click', () => {
            const data = editor.getData();
            Livewire.dispatch('save-content', { value: data });
        });
    }
    const minLength = 30;
    const maxLength = 1000;

    // 🔹 Khi nội dung thay đổi
    editor.model.document.on('change:data', () => {
        const data = editor.getData().replace(/<[^>]*>/g, '').trim();
        const length = data.length;

        if (length === 0) {
            feedback.textContent = `Please enter content (minimum ${minLength} characters).`;
            feedback.style.color = '#888';
        }
        else if (length < minLength) {
            feedback.textContent = `Content is too short (${length}/${minLength} characters minimum).`;
            feedback.style.color = '#e67e22'; // orange
        }
        else if (length > maxLength) {
            feedback.textContent = `Content exceeds the limit (${length}/${maxLength} characters maximum)!`;
            feedback.style.color = '#e74c3c'; // red
        }
        else {
            feedback.textContent = `Valid length (${length}/${maxLength} characters).`;
            feedback.style.color = '#2ecc71'; // green
        }
    });
}).catch(error => {
    console.error(error);
});


// window.editor = editor;
