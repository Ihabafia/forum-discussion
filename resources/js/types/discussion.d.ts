export class DiscussionObject {
    id: number;
    title: string;
    slug: string;
    topic: Topic;
    post: PostObject;
    solution: PostObject;
    user: User;
    participants: object;
    is_pinned: boolean;
    replies_count: number;
    user_can: object;
    latest_post: PostObject;
}

export class Discussions {
    data: array<DiscussionObject[]>;
    links: object;
    meta: object;
}

export class Posts {
    data: array<PostObject[]>;
    links: object;
    meta: object;
}

export class TopicObject {
    id: number;
    slug: string;
    title: string;
}

export class UserObject {
    id: number;
    username: string;
    name: string;
    avatar: string;
    email?: string;
    created_at: string;
}

export class PostObject {
    id: number;
    body: string;
    body_markdown: string;
    body_preview: string;
    user: User;
    user_can: object;
    discussion: DiscussionObject;
    created_at: CreatedAt;
}

export class CreatedAt {
    human: string;
    datetime: string;
    date: string;
    fancy: string;
    fancy_day: string;
    fancy_date: string;
}
