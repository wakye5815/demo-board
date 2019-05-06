export type User = {
    id: number,
    name: string,
    email: string
};

export type Comment = {
    comment_id: number,
    board_id: number,
    content: string,
    owner_id: number,
    owner_name: string,
    created_at: string,
    updated_at: string
};

export type Board = {
    id: number,
    name: string,
    owner_name: string,
    created_at: string,
    updated_at: string
};