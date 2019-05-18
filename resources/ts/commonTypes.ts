export type User = {
    id: number,
    name: string,
    email: string
};

export type Comment = {
    id: number,
    board_id: number,
    content: string,
    owner_user: User,
    created_at: string,
    updated_at: string
    is_reply: boolean,
    reply_to_comment?: Comment
};

export type Board = {
    id: number,
    name: string,
    owner_name: string,
    created_at: string,
    updated_at: string
};