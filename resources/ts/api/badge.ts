import httpClient from './httpClient';
import * as types from './types'
import { Badge } from '../commonTypes'

namespace BadgeApiUrl {
    export const MASTER = '/api/badge/master';
}

export async function fetchBadgeMaster(): Promise<types.SuccessApiResponse<{ badge_master: Badge[] }> | types.FailuerApiResponse<{}>> {
    return await httpClient
        .get(BadgeApiUrl.MASTER);
}