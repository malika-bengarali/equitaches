import { getUser } from "./api";

let cachedUser = null;
let cacheTime = 0;
const CACHE_DURATION = 5 * 60 * 1000; // 5 minutes

export async function getCurrentUser(forceRefresh = false) {
  const now = Date.now();
  
  // Si cache valide et pas de forçage, retourner le cache
  if (!forceRefresh && cachedUser && (now - cacheTime < CACHE_DURATION)) {
    return cachedUser;
  }

  // Sinon, récupérer depuis le serveur
  try {
    const res = await getUser();
    if (res.data.success) {
      cachedUser = res.data.user;
      cacheTime = now;
      return cachedUser;
    } else {
      cachedUser = null;
      return null;
    }
  } catch (err) {
    console.error("Erreur récupération utilisateur:", err);
    cachedUser = null;
    return null;
  }
}

export function clearUserCache() {
  cachedUser = null;
  cacheTime = 0;
}