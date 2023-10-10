import InputError from "@/Components/InputError.jsx";
import InputLabel from "@/Components/InputLabel.jsx";
import PrimaryButton from "@/Components/PrimaryButton.jsx";
import TextInput from "@/Components/TextInput.jsx";
import { Link, router, useForm, usePage } from "@inertiajs/react";
import { Transition } from "@headlessui/react";

export default function CreateFeedbackForm({ className = "" }) {
    const { data, setData, post, errors, processing, recentlySuccessful } =
        useForm({
            title: "",
            description: "",
            category: "",
            image: "",
        });

    const submit = (e) => {
        e.preventDefault();
        const fd = new FormData();
        Object.keys(data).forEach((item) => {
            fd.append(item, data[item]);
        });
        router.visit(route("feedback.store"), {
            method: "post",
            data: fd,
            headers: {
                Accept: "application/json",
                "Content-Type": "multipart/form-data",
            },
        });
    };

    return (
        <section className={className}>
            <header>
                <h2 className="text-lg font-medium text-gray-900">
                    Create Feedback
                </h2>
            </header>

            <form onSubmit={submit} className="mt-6 space-y-6">
                <div>
                    <InputLabel htmlFor="name" value="Name" />

                    <TextInput
                        id="title"
                        className="mt-1 block w-full"
                        value={data.title}
                        onChange={(e) => setData("title", e.target.value)}
                        required
                        isFocused
                        autoComplete="name"
                    />

                    <InputError className="mt-2" message={errors.title} />
                </div>

                <div>
                    <InputLabel htmlFor="category" value="Category" />
                    <select
                        className="w-full rounded border-gray-300"
                        value={data.category}
                        onChange={(e) => setData("category", e.target.value)}
                    >
                        <option value="">Select</option>
                        <option value="bug">Bug</option>
                        <option value="feature">Feature</option>
                        <option value="improvement">Improvement</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div>
                    <InputLabel htmlFor="Description" value="Description" />

                    <textarea
                        id="title"
                        className="mt-1 block w-full border-slate-300 rounded resize-none"
                        value={data.description}
                        onChange={(e) => setData("description", e.target.value)}
                        required
                        isFocused
                        autoComplete="name"
                    />

                    <InputError className="mt-2" message={errors.description} />
                </div>

                <div>
                    <input
                        type="file"
                        name="image"
                        id="image"
                        multiple={false}
                        onChange={(e) => {
                            const { files } = e.target;
                            setData("image", files[0]);
                        }}
                    />
                </div>

                <div className="flex items-center gap-4">
                    <PrimaryButton disabled={processing}>Save</PrimaryButton>

                    <Transition
                        show={recentlySuccessful}
                        enter="transition ease-in-out"
                        enterFrom="opacity-0"
                        leave="transition ease-in-out"
                        leaveTo="opacity-0"
                    >
                        <p className="text-sm text-gray-600">Saved.</p>
                    </Transition>
                </div>
            </form>
        </section>
    );
}
