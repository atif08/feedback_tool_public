import TextInput from "@/Components/TextInput";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, router } from "@inertiajs/react";
import { useEffect, useState } from "react";
import DataTable from "react-data-table-component";

export default function Dashboard({ auth, feedback }) {
    const [params, setParams] = useState({});
    const columns = [
        {
            name: "Title",
            selector: (row) => row.title,
            sortable: true,
        },
        {
            name: "Votes",
            selector: (row) => row.up_vote_count+row.down_vote_count,
            sortable: true,
        },
        {
            name: "Category",
            selector: (row) => row.category,
            sortable: true,
        },
        {
            name: "User",
            selector: (row) => row.user.name,
            sortable: true,
        },
        {
            cell: (row) => (
                <Link
                    className="px-4 py-2 rounded text-white bg-blue-500"
                    href={`/feedback/${row.id}`}
                >
                    View
                </Link>
            ),
        },
    ];

    const handlePageChange = (page) => {
        setParams((p) => ({ ...p, page }));
        router.visit("?", {
            preserveState: true,
            data: {...params,"page":page},
        });
    };

    function handleChange(e) {
        const { value } = e.target;
        setParams((p) => ({ ...p, "filter[title]": value }));
        router.visit("?", {
            preserveState: true,
            data: {...params,"filter[title]":value},
        });
    }




    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Dashboard
                </h2>
            }>

            <Head title="Dashboard" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-4 flex items-center justify-between">
                            <TextInput
                                name="search"
                                placeholder="Search..."
                                onChange={handleChange}
                                value={params["filter[title]"]}
                            />
                            <Link
                                href={"/feedback/create"}
                                className="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 false "
                            >
                                {" "}
                                Create Feedback
                            </Link>
                        </div>
                        <DataTable
                            columns={columns}
                            data={feedback.data}
                            pagination
                            paginationServer
                            paginationTotalRows={feedback.total}
                            paginationPerPage={feedback.per_page}
                            onChangePage={handlePageChange}
                            paginationDefaultPage={feedback.current_page}
                            paginationRowsPerPageOptions={[feedback.per_page]}
                        />
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
