import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.jsx";
import { Head, router } from "@inertiajs/react";
import { useState } from "react";
import { MentionsInput, Mention } from "react-mentions";
import menuInputStyle from "../../../css/menuInputStyle";

export default function Edit({ auth, feedback,users}) {
    const [commentText, setCommentText] = useState("");
    const [mentions, setMentions] = useState([]);

    function handleCommentSubmit() {
        router.visit(route("feedback.comment", feedback.id), {
            method: "post",
            data: {
                content: commentText,
                mentions,
            },
            forceFormData: true,
            onSuccess: () => {
                router.reload({ only: [feedback] });
            },
        });
    }
    function handleUpVote() {
        router.visit(route("feedback.upvote", feedback.id), {
            method: "post",
            onSuccess: () => {
                router.reload({ only: [feedback] });
            },
        });
    }
    function handleDownVote() {
        router.visit(route("feedback.downvote", feedback.id), {
            method: "post",
            onSuccess: () => {
                router.reload({ only: [feedback] });
            },
        });
    }

    function handleCommentChange(event, newValue, newPlainTextValue, mentions) {
        setCommentText(event.target.value);
        setMentions(mentions);
    }
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
                        <h1>
                            <strong>Title:</strong> {feedback.title}
                        </h1>
                        <h1>
                            <strong>Description:</strong> {feedback.description}
                        </h1>
                        {

                            feedback.media[0] ? <img width={500} height={500} src={feedback?.media[0]?.original_url}/> :''
                        }

                        <h1>
                            <button className="bg-blue-500 text-white px-4 py-2 rounded hover:opacity-70 mt-4" onClick={handleUpVote}>Up Vote:</button> {feedback.up_vote_count}
                        </h1>
                        <h1>
                            <button className="bg-red-500 text-white px-4 py-2 rounded hover:opacity-70 mt-2" onClick={handleDownVote}>Down Vote:</button>{" "}
                            {feedback.down_vote_count}
                        </h1>
                    </div>

                    <div className="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <h1>
                            <strong>Comments</strong>
                        </h1>
                        {feedback?.comments.length > 0 ? (
                            feedback?.comments.map(function (comment) {
                                return (
                                    <div
                                        key={comment.id}
                                        className="border py-2 px-4 rounded my-4"
                                    >
                                        {" "}
                                        {/* Make sure to provide a unique key */}
                                        <h1>
                                            <strong>Description:</strong>{" "}
                                            {comment.text?.replace(
                                                /<[^>]*>?/gm,
                                                ""
                                            )}
                                        </h1>
                                    </div>
                                );
                            })
                        ) : (
                            <p className="text-xs italic mt-1">
                                No comments were found for this feedback...
                            </p>
                        )}

                        <div className="mt-4">
                            <h2 className="font-bold">Write a comment</h2>
                            <div className="relative mt-2">
                                <MentionsInput
                                    value={commentText}
                                    onChange={handleCommentChange}
                                    style={menuInputStyle}
                                >
                                    <Mention
                                        trigger="@"
                                        data={users}
                                        style={{
                                            backgroundColor: "#cee4e5",
                                        }}
                                    />
                                </MentionsInput>
                            </div>
                            <div className="text-end">
                                <button
                                    type="button"
                                    className="text-white bg-blue-500 rounded px-4 py-2 mt-2 text-end"
                                    onClick={handleCommentSubmit}
                                >
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
