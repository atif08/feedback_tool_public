import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.jsx";
import CreateFeedbackForm from "./Partials/CreateFeedbackForm.jsx";
import { Head } from "@inertiajs/react";

export default function Edit({ auth }) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Create Feedback
                </h2>
            }
        >
            <Head title="Create Feedback" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div className="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <CreateFeedbackForm className="max-w-xl" />
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
