import { Plugin, ButtonView } from 'ckeditor5';

class CustomUploadAdapter {
    constructor(loader) {
        this.loader = loader;
    }

    upload() {
        return new Promise((resolve, reject) => {
            Livewire.once('imagesInsert', (urls) => {

                if (!urls || !urls.length) {
                    reject('Upload failed');
                } else {
                    const url = urls[0];
                    resolve({ default: url });
                }
            });
        });
    }

    abort() { }
}

export default function CustomUploadPlugin(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
        return new CustomUploadAdapter(loader);
    };

    editor.ui.componentFactory.add('chooseImage', locale => {
        const view = new ButtonView(locale);

        view.set({
            label: 'Select Image',
            icon: `
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2.5" y="4.5" width="19" height="15" rx="2" ry="2"></rect>
                    <path d="M3.5 18.5h17"></path>
                    <path d="M7 14l3-4 4 5 2-3 3 4"></path>
                    <path d="M12 13V6"></path>
                    <path d="M9 9l3-3 3 3"></path>
                </svg>
                    `,
            tooltip: true
        });

        view.on('execute', () => {
            Livewire.dispatch('openImagePicker');
        });

        return view;
    });
    Livewire.on('imagesInsert', (urls) => {
        console.log('Nhận URL từ Livewire:', urls);
        if (!urls || !urls.length) return;

        // urls.forEach(url => {
        //     editor.model.change(writer => {
        //         // tạo imageBlock thay vì image
        //         const imageElement = writer.createElement('imageBlock', {
        //             src: url,
        //             alt: 'Uploaded image'
        //         });

        //         // insert vào vị trí hiện tại của con trỏ
        //         editor.model.insertContent(
        //             imageElement,
        //             editor.model.document.selection
        //         );
        //         writer.setSelection(imageElement, 'after');
        //     });
        // });
        editor.model.change(writer => {
            const fragment = writer.createDocumentFragment();

            urls.forEach(url => {
                const imageElement = writer.createElement('imageBlock', { src: url });
                writer.append(imageElement, fragment);
            });

            editor.model.insertContent(fragment, editor.model.document.selection);
        });

    });
}
