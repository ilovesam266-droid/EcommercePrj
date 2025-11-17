// class CustomUploadAdapter {
//     constructor(loader) {
//         this.loader = loader;
//     }

//     upload() {
//         return this.loader.file.then(() => {
//             return new Promise((resolve, reject) => {
//                 // Mở modal chọn ảnh
//                 window.Livewire.emit('openImagePicker');

//                 // Nhận URL ảnh từ Livewire
//                 window.Livewire.on('imageUploaded', (url) => {
//                     if (!url) {
//                         reject('Upload failed');
//                     } else {
//                         resolve({ default: url });
//                     }
//                 });
//             });
//         });
//     }

//     abort() {}
// }

// export default function CustomUploadPlugin(editor) {
//     editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
//         return new CustomUploadAdapter(loader);
//     };
// }

import { Plugin, ButtonView } from 'ckeditor5';

class CustomUploadAdapter {
    constructor(loader) {
        this.loader = loader;
    }

    upload() {
        return this.loader.file.then(() => {
            return new Promise((resolve, reject) => {
                // Mở modal chọn ảnh
                window.Livewire.emit('openImagePicker');

                // Nhận URL ảnh từ Livewire
                window.Livewire.on('imageUploaded', (url) => {
                    if (!url) {
                        reject('Upload failed');
                    } else {
                        resolve({ default: url });
                    }
                });
            });
        });
    }

    abort() {}
}

export default function CustomUploadPlugin(editor) {
    // Đăng ký upload adapter
    editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
        return new CustomUploadAdapter(loader);
    };

    // Đăng ký nút custom trong toolbar
    editor.ui.componentFactory.add('chooseImage', locale => {
        const view = new ButtonView(locale);

        view.set({
            label: 'Chọn ảnh',
            icon: '<svg>...</svg>', // icon tuỳ chọn
            tooltip: true
        });

        view.on('execute', () => {
            // 👉 Mở modal Livewire khi click nút
            window.Livewire.emit('openImagePicker');
        });

        return view;
    });
}
