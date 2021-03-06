export type User = {
    id: number,
    name: string,
    email: string,
    badge_id: number
};

export type Comment = {
    id: number,
    board_id: number,
    content: string,
    owner_user: User,
    created_at: string,
    updated_at: string
    is_reply: boolean,
    is_deleted: boolean,
    to_comment?: Comment
};

export type Board = {
    id: number,
    name: string,
    owner_user: User,
    created_at: string,
    updated_at: string
};

export type Badge = {
    badge_id: number,
    name: string,
    description: string
}